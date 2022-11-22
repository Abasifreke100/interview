<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LoanHistory\Modules\Loan\Models\penalty;

class PenaltyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = penalty::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
