<?php


namespace LoanHistory\Modules\Loan\Api\v1\Controllers;


use Illuminate\Http\Request;
use LoanHistory\Modules\BaseController;
use LoanHistory\Modules\Loan\Api\v1\Requests\AddLoanRequest;
use LoanHistory\Modules\Loan\Api\v1\Repositories\LoanRepository;
use LoanHistory\Modules\Loan\Api\v1\Requests\LoanRequest;
use LoanHistory\Modules\Loan\Api\v1\Transformers\LoanTransformer;
use LoanHistory\Modules\Loan\Api\v1\Transformers\LoanUserTransformer;
use LoanHistory\Modules\Project\Api\v1\Transformers\LoaneeTransformer;
use LoanHistory\Modules\Project\Api\v1\Repositories\LoaneeWalletRepository;

class LoanController extends BaseController
{

    protected $loanRepository;
    protected $loanTransformer;
    protected $loanUserTransformer;

    public function __construct(LoanRepository $loanRepository,
                                LoanTransformer $loanTransformer,
                                LoanUserTransformer $loanUserTransformer)
    {
        $this->loanRepository = $loanRepository;
        $this->loanTransformer = $loanTransformer;
        $this->loanUserTransformer = $loanUserTransformer;
    }


    /** List Loans */
    public function index()
    {
        $loan  = $this->loanRepository->index();
        return $this->successWithPages($loan, $this->loanTransformer, 'loans');
    }

    /** Approve Loan */
    public function approveLoan(Request $request){
        $this->validate($request,[
            "apply_id"=>"required|exists:loan_users,id",
        ]);

        $loan = $this->loanRepository->approveLoan($request->all());
        if (!isset($loan['status_code'])) {
            return $this->transform($loan, $this->loanUserTransformer);
        }

        return $this->handleErrorResponse($loan);
    }

    /** Create Loan */
    public function createLoan(AddLoanRequest $request)
    {
        $data = $this->loanRepository->createLoan($request);
        if (!isset($data['status_code'])){
            return $this->transform($data, $this->loanTransformer);
        }

        return $this->handleErrorResponse($data);
    }


    /**Show single loan  */
    public function show($id){

        $loan = $this->loanRepository->show($id);

        if (!isset($loan['status_code'])){
            return $this->transform($loan, $this->loanTransformer);
        }

        return $this->handleErrorResponse($loan);
    }

    /** Loan Interest */
    Public function showLoanInterest(){
        $interest = $this->loanRepository->showLoanInterest();
        return $this->success($interest);
    }

    /** Loan Penalty */
    public function showLoanPenalties(){
        $penalty = $this->loanRepository->showLoanPenalties();
        return $this->success($penalty);
    }

    /** Request Loan */
    public function requestLoan(LoanRequest $request){

        $requestLoan = $this->loanRepository->requestLoan($request->all());
        if (!isset($loan['status_code'])){
            return $this->transform($requestLoan, $this->loanUserTransformer);
        }

        return $this->handleErrorResponse($requestLoan);
    }

    /** Applied Loan */
    public function appliedLoan(){
        $appliedLoan =  $this->loanRepository->appliedLoan();
        return $this->successWithPages($appliedLoan, $this->loanUserTransformer,'loans');
    }

    /** Make Daily payment */
    public function makeDailyPayment(Request $request){

        $this->validate($request,[
            "id"=>"required|exists:loan_users,id",
            'amount'=>'required',
        ]);

        $loan = $this->loanRepository->makeDailyPayment($request->all());
        if (!isset($loan['status_code'])){
            return $this->transform($loan, $this->loanUserTransformer);
        }

        return $this->handleErrorResponse($loan);
    }

    public function transaction(){
        return $this->success($this->loanRepository->transaction());
    }


}
