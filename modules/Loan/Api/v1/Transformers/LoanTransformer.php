<?php

namespace LoanHistory\Modules\Loan\Api\v1\Transformers;

use League\Fractal\TransformerAbstract;
use LoanHistory\Modules\Loan\Models\Loan;

class LoanTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [];

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
    public function transform(Loan $loan)
    {

        return [
            "id"=>$loan->id,
            "loan_category_id"=>$loan->loan_category_id,
            "interest_id"=>$loan->interest_id,
            "penalty_id" => $loan->penalty_id,
            "amount"=> $loan->amount,
            "total_due" => $loan->total_due,
            "status"=>$loan->status,
            "created_at"=>$loan->created_at,
            "interest_rate"=>$loan->interest,
            "loan_category" => $loan->loanCategory,
            "penalty"=>$loan->penalty,
        ];

    }




}
