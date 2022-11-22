<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use LoanHistory\Modules\BaseRepository;

class LoanCategoryTableSeeder extends Seeder
{
    protected $baseRepository;

    public function __construct(BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        if (DB::table('loan_categories')->count() == 0)
            $this->seedLoanCategories();
    }

    /**
     * @throws \Exception
     */
    public function seedLoanCategories(){
        $dataTime = Carbon::parse('UTC')->now();

        $loanCategories = [
            [
                'id'=>$this->baseRepository->generateUuid(),
                'name'=>'Personal Loan',
                'slug'=>'personal_loan',
                'created_at'=>$dataTime,
                'updated_at'=>$dataTime
            ],

            [
                'id'=>$this->baseRepository->generateUuid(),
                'name'=>'Home Loan',
                'slug'=>'home_loan',
                'created_at'=>$dataTime,
                'updated_at'=>$dataTime
            ],

            [
                'id'=>$this->baseRepository->generateUuid(),
                'name'=>'Business Loan',
                'slug'=>'business_loan',
                'created_at'=>$dataTime,
                'updated_at'=>$dataTime
            ],

            [
                'id'=>$this->baseRepository->generateUuid(),
                'name'=>'Education Loan',
                'slug'=>'education_loan',
                'created_at'=>$dataTime,
                'updated_at'=>$dataTime
            ],

            [
                'id'=>$this->baseRepository->generateUuid(),
                'name'=>'Car Loan',
                'slug'=>'car_loan',
                'created_at'=>$dataTime,
                'updated_at'=>$dataTime
            ]

        ];

        DB::table('loan_categories')->insert($loanCategories);

    }
}
