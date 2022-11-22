<?php

namespace LoanHistory\Modules\Auth\Api\v1\Transformers;

use League\Fractal\TransformerAbstract;
use LoanHistory\Modules\Auth\Models\User;
use LoanHistory\Modules\Loan\Api\v1\Transformers\LoanTransformer;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'loan'
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [

    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            "id" => $user->id,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "phone" => $user->phone,
            "status" => $user->status,
            "role_id" => $user->id,
            "role" => $user->role,
        ];
    }

    public function includeLoan(User $user){
        return $this->collection($user->loan, new LoanTransformer);
    }
}
