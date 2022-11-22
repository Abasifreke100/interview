<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id');
            $table->string('loan_category_id');
            $table->string('penalty_id');
            $table->string('interest_id');
            $table->string('interest')->nullable();
            $table->double('amount');
            $table->enum('status',["active","due","settled","pending","defaulter"])->default("pending")->nullable();
            $table->string('date_issued')->nullable();
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
        Schema::dropIfExists('loans');
    }

}


// 08135802551
