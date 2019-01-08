<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('sales_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('transaction_exp_id');
            $table->integer('transaction_year');
            $table->integer('transaction_month');
            $table->string('customer_id');
            $table->string('customer_name');
            $table->string('customer_mobile')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_captureDate')->nullable();
            $table->float('customer_limit')->default(0.0);
            $table->string('tran_prd_grp')->index();
            $table->string('tran_prd_name')->index();
            $table->float('tran_commission_amount')->default(0.0);
            $table->string('tran_prd_SalesExecutiveCODE')->index();
            $table->string('tran_prd_SalesExecutiveName')->index();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_transaction');
    }
}
