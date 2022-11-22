<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use LoanHistory\Modules\BaseRepository;
use LoanHistory\Modules\Auth\Models\User;
use LoanHistory\Modules\Auth\Models\Wallet;
use LoanHistory\Modules\Project\Models\Loanee;

class UserTableSeeder extends Seeder
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
        if (DB::table('roles')->count() == 0)
            $this->seedRoles();

        $superAdmin = DB::table('roles')->where("slug","super_admin")->first();
        /** Seed Admin User */
        $admin = User::create([
            "id" => $this->baseRepository->generateUuid(),
            "role_id" => $superAdmin->id,
            "first_name" => "Super",
            "last_name" => "Admin",
            "email" => "superadmin@gmail.com",
            "password" => bcrypt("password"),
        ]);
        Wallet::create([
            "id" => $this->baseRepository->generateUuid(),
            "user_id" => $admin->id,
            "balance" => 0.00
        ]);



        /** Seed Loanee User */
        $role = DB::table('roles')->where("slug","loanee")->first();
        $loanee = User::create([
            "id" => $this->baseRepository->generateUuid(),
            "role_id" => $role->id,
            "first_name" => "John",
            "last_name" => "Doe",
            "email" => "johndoe@gmail.com",
            "password" => bcrypt("password"),
        ]);
        Wallet::create([
            "id" => $this->baseRepository->generateUuid(),
            "user_id" => $loanee->id,
            "balance" => 0.00
        ]);
    }

    public function seedRoles(){
        $time = Carbon::parse('UTC')->now();

        $roles = [
            [
                'id'=>$this->baseRepository->generateUuid(),
                'name'=>'Super Admin',
                'slug'=>'super_admin',
                'created_at'=>$time,
                'updated_at'=>$time
            ],
            [
                'id'=>$this->baseRepository->generateUuid(),
                'name'=>'Loanee',
                'slug'=>'loanee',
                'created_at'=>$time,
                'updated_at'=>$time
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
