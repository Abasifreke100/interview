<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            LoanCategoryTableSeeder::class,
            InterestSeeder::class,
            PenaltySeeder::class
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
