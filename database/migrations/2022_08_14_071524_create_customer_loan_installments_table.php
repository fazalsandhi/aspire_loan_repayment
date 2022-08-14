<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerLoanInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_loan_installments', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_loan_header_id')->nullable();
            $table->double('installment_amt')->nullable();
            $table->date('installment_date')->nullable();
            $table->double('remaining_amt')->nullable();
            $table->enum('status',['Pending','Paid'])->default('Pending');
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
        Schema::dropIfExists('customer_loan_installments');
    }
}
