<?php

namespace LoanHistory\Modules\Loan\Api\v1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "category_id"=>"required|exists:loan_categories,id",
            "interest_id"=>"required|exists:interests,id",
            "penalty_id"=>"required|exists:penalties,id",
            "amount"=>"required",
        ];
    }

}
