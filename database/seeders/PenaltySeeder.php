<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use LoanHistory\Modules\BaseRepository;
use LoanHistory\Modules\Loan\Models\Penalty;

class PenaltySeeder extends Seeder
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
        if (DB::table('penalties')->count() == 0){
            $this->seedPenalties();
        }
    }

    public function seedPenalties(){
        Penalty::create([
            "id" => $this->baseRepository->generateUuid(),
            "name" => "overdue",
            "percentage" => 1
        ]);
    }
}
