<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->string('loan_id');
            $table->double('amount_paid');
            $table->double('balance');
            $table->double('final_due')->nullable();
            $table->string('amount', 50)->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->double('overdue_charge')->nullable();
            $table->string('total_due', 50)->nullable();
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_users');
    }
}
