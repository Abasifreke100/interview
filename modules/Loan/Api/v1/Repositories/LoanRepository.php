<?php


namespace LoanHistory\Modules\Loan\Api\v1\Repositories;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use LoanHistory\Modules\BaseRepository;
use LoanHistory\Modules\Auth\Models\Role;
use LoanHistory\Modules\Auth\Models\User;
use LoanHistory\Modules\Loan\Models\Loan;
use LoanHistory\Modules\Auth\Models\Wallet;
use LoanHistory\Modules\Loan\Models\Penalty;
use LoanHistory\Modules\Loan\Models\Interest;
use LoanHistory\Modules\Loan\Models\LoanUser;
use LoanHistory\Modules\Loan\Models\Transaction;


class LoanRepository extends BaseRepository
{
    protected $interest;
    protected $penalty;
    protected $loan;
    protected $wallet;
    protected $user;
    protected $role;
    protected $loanUser;
    protected $transaction;


    public function __construct()
    {
        $this->loan = app(Loan::class);
        $this->role = app(Role::class);
        $this->user = app(User::class);
        $this->interest = app(Interest::class);
        $this->penalty = app(Penalty::class);
        $this->wallet = app(Wallet::class);
        $this->loanUser = app(LoanUser::class);
        $this->transaction = app(Transaction::class);
    }

    private function wallet(){
        return $this->wallet->where("user_id", auth()->id())->first();
    }

    private function loaneeUser($data){
        $loan = $this->loanUser->where("id", $data->id)
            ->where("user_id", auth()->id())->first();

        if (!$loan) {
            return $this->failResponse("Loan not found", 404);
        }

        return $loan;
    }

    private function getPenalty() {
        return $this->penalty->where('name', 'overdue')->first();
    }

    private function getInterest() {
        return $this->interest->where('type', 'yearly')->first();
    }

    private function getInterestById($interestId) {
        return $this->interest->where('id', $interestId)->first();
    }

    private function calculateTotalDue($interestId, $amount, $startDate, $endDate) {
        $years = Carbon::parse($startDate)->diffInYears(Carbon::parse($endDate));
        return doubleval($amount) * pow(1 + (doubleval($this->getInterestById($interestId)->percentage)/100), $years);
    }

    private function calculateDailyDue($loanUser)
    {
        $daysPassed = Carbon::parse($loanUser->endDate)->diffInDays(Carbon::now());
        return doubleval($loanUser->final_due ?? $loanUser->total_due) * pow((1 + 1 / 100), $daysPassed);
    }

    private function updateLoanDailyOverdueBalances(LoanUser $loanRequest)
    {
        $totalDue = $this->calculateDailyDue($loanRequest);

        $loanRequest->balance += ($totalDue - $loanRequest->total_due);
        $loanRequest->overdue_charge = $totalDue - $loanRequest->total_due;
        $loanRequest->final_due = $totalDue;
        $loanRequest->save();

        return $loanRequest->fresh();
    }

    private function updateLoanBalancesOnAcceptance(LoanUser $loanRequest) {
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addYear();

        $totalDue = $this->calculateTotalDue($loanRequest->loan->interest_id, $loanRequest->loan->amount, $startDate, $endDate);

        $loanRequest->status = 'approved';
        $loanRequest->total_due = $totalDue;
        $loanRequest->balance = $totalDue;
        $loanRequest->start_date = $startDate;
        $loanRequest->end_date = $endDate;
        $loanRequest->save();

        return $loanRequest->fresh();
    }

    private function updateWallet(LoanUser $loanRequest) {
        $userWallet = $loanRequest->user->wallet;
        $userWallet->balance += $loanRequest->loan->amount;
        $userWallet->save();
    }

    private function createTransactionForLoanApproval(LoanUser $loanRequest) {

        $this->transaction->create([
            'user_id' => $loanRequest->user->id,
            'loan_id' => $loanRequest->loan->id,
            'wallet_id' => $loanRequest->user->wallet->id,
            'transactionable_type' => 'Borrow',
            'transactionable_id' => $loanRequest->loan->id,
            'amount' => $loanRequest->loan->amount,
            'status' => 'Successful',
        ]);
    }

    private function createTransactionForLoanPayback(LoanUser $loanRequest, $amount) {

        $this->transaction->create([
            'user_id' => $loanRequest->user->id,
            'loan_id' => $loanRequest->loan->id,
            'wallet_id' => $loanRequest->user->wallet->id,
            'transactionable_type' => 'Payback',
            'transactionable_id' => $loanRequest->loan->id,
            'amount' => $amount,
            'status' => 'Successful',
        ]);
    }

    private function getDailyPayment($amount, $interval)
    {
        $interest = ($this->interest) * $amount / 100;
        return ($amount + $interest) / $interval;
    }

    private function getPercent($amount)
    {
        $interest = doubleval($this->interest->first()->percentage) * $amount / 100;
        return $interest + $amount;
    }

    private function getDiffInWeekdays($end_date)
    {
        $startDate = Carbon::now();
        $endDate = Carbon::parse($end_date);
        return $endDate->diffInWeekdays($startDate);
    }

    private function deductBalance($balance,$amount)
    {
        return $balance - $amount;
    }

    private function addBalance($balance, $amount){
        return $balance + $amount;
    }

    /** List Loans */
    public function index()
    {
        return $this->loan->orderBy("created_at","DESC")
            ->latest()
            ->paginate(10);
    }

    public function approveLoan($request)
    {
        $data = (object) $request;

        $loan = $this->loanUser->where("id", $data->apply_id)
            ->first();

        if($loan->status != 'pending') {
            return $this->failResponse("Loan is {$loan->status}!");
        }

        $this->updateLoanBalancesOnAcceptance($loan);
        $this->updateWallet($loan);
        $this->createTransactionForLoanApproval($loan);

        return $loan;
    }

    public function show($id){

        $loan = $this->loan->find($id);

        if(!$loan){
            return $this->failResponse("Loan not found", 404);
        }

        return $loan;
    }

    /** Loan Interest */
    Public function showLoanInterest(){
        return $this->interest->all();
    }

    /** Loan Percentage */
    public function showLoanPenalties(){
        return $this->penalty->all();
    }

    public function requestLoan($requestData){

        $user_id = auth()->id();
        $data = (object) $requestData;

        $checkExistingLoan = $this->loanUser->where("user_id",auth()->id())
            ->where("loan_id",$data->loan_id)->first();

        if ($checkExistingLoan){
            return $this->failResponse("Loans are already exist",409);
        }

        return $this->loanUser->create([
            "user_id" => $user_id,
            "loan_id" => $data->loan_id,
            "status"=> "pending",
            "amount_paid" => 0,
            "balance" => 0,
        ]);
    }


    /** Create Loan */
    public function createLoan($request)
    {
        if (!is_float((float)$request->amount)) {
            return $this->failResponse('Amount must be an integer or float', 422);
        }

        DB::beginTransaction();

        $lender = $this->user->where('role_id', $this->role->where('slug', 'super_admin')->first()->id)->first();
        $loan = $this->loan->create([
            "id" => $this->generateUuid(),
            "user_id" => $lender->id,
            "loan_category_id" => $request->category_id,
            "penalty_id" => $request->penalty_id,
            "interest_id" => $request->interest_id,
            "amount" => round($request->amount),
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "interest" => round($this->getInterest()->percentage, 2),
            'total_due' => $this->calculateTotalDue($request->interest_id, $request->amount, $request->start_date, $request->end_date),
            "status" => "active",
        ]);

        if (!$loan){
            DB::rollBack();
            return $this->failResponse('Cannot request for loan',422);
        }

        DB::commit();
        return $loan;
    }

    public function appliedLoan(){
        return $this->loanUser
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'DESC')
            ->latest()
            ->paginate(10);
    }

    public function makeDailyPayment($requestData){

        $data = (object) $requestData;
        if ($data->amount == 0){
            return $this->failResponse("Please enter a valid amount",500);
        }

        $loan = $this->loaneeUser($data);
        $balance = round($this->deductBalance($loan->balance, $data->amount));
        $loan->update(['balance' => $balance]);
        $loan->update(['amount_paid' => $this->addBalance($loan->amount_paid, $data->amount)]);

        $this->createTransactionForLoanPayback($loan, $data->amount);
        $this->updateLoanDailyOverdueBalances($loan);

        return $loan;
    }

    public function transaction(){
        return $this->transaction->where("user_id", auth()->id())
            ->orderBy("created_at","DESC")
            ->latest()
            ->get();
    }

}
