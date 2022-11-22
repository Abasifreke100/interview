<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use LoanHistory\Modules\BaseRepository;
use LoanHistory\Modules\Loan\Models\Interest;

class InterestSeeder extends Seeder
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
     */
    public function run()
    {
        if (DB::table('interests')->count() == 0){
            $this->seedInterests();
        }

    }

    public function seedInterests(){

        Interest::create([
            "id" => $this->baseRepository->generateUuid(),
            "type" => "yearly",
            "percentage" => 8,
        ]);

        Interest::create([
            "id" => $this->baseRepository->generateUuid(),
            "type" => "daily",
            "percentage" => 1,
        ]);
    }
}
