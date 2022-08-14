<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerLoanHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_loan_headers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('loan_number')->nullable();
            $table->double('loan_amount')->nullable();
            $table->double('loan_term')->nullable();
            $table->enum('status',['Pending','Approved','Paid'])->default('Pending');
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
        Schema::dropIfExists('customer_loan_headers');
    }
}
