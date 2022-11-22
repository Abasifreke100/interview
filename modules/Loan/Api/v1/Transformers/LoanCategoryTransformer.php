<?php

namespace LoanHistory\Modules\Loan\Api\v1\Transformers;

use League\Fractal\TransformerAbstract;
use LoanHistory\Modules\Loan\Models\LoanCategory;

class LoanCategoryTransformer extends TransformerAbstract
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
    public function transform(LoanCategory $loanCategory)
    {
        return [
            "id" =>$loanCategory->id,
            "name" =>$loanCategory->name,
            "slug" =>$loanCategory->slug
        ];
    }
}
