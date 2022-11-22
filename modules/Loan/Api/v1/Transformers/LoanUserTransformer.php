<?php

namespace LoanHistory\Modules\Loan\Api\v1\Transformers;

use League\Fractal\TransformerAbstract;
use LoanHistory\Modules\Loan\Models\LoanUser;

class LoanUserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(LoanUser $loanUser)
    {
        return [
            "id" => $loanUser->id,
            "user_id" => $loanUser->user_id,
            "loan_id" => $loanUser->loan_id,
            "amount_paid" => doubleval($loanUser->amount_paid),
            "balance" => doubleval($loanUser->balance),
            "total_due" => $loanUser->total_due,
            "start_date" => $loanUser->start_date,
            "end_date" => $loanUser->end_date,
            "overdue_charge" => $loanUser->overdue_charge,
            "final_due" => $loanUser->final_due,
            "status" => $loanUser->status,
            "request_date" => $loanUser->created_at,
            "loan" => $loanUser->loan,
            "user" => $loanUser->user
        ];
    }
}
