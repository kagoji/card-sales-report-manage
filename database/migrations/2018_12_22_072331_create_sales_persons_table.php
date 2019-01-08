<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('sales_persons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('salesExecutiveCode')->index()->unique();
            $table->string('salesExecutiveName');
            $table->string('salesDesigCode')->index();
            $table->foreign('salesDesigCode')->references('designationCode')
                ->on('sales_config')->onUpdate('cascade');
            $table->string('salesDesigTitle');
            $table->foreign('salesDesigTitle')->references('designationTitle')
                ->on('sales_config')->onUpdate('cascade');
            $table->date('dateOfJoining');
            $table->string('sales_persons_account_no')->nullable();
            $table->string('sales_persons_mobile_no')->nullable();
            $table->integer('sales_persons_zone_id');
            $table->string('sales_persons_zone_name');
            $table->foreign('sales_persons_zone_name')->references('zone_name')
                ->on('sales_zone')->onUpdate('cascade');
            $table->integer('sales_persons_target')->default(0);
            $table->foreign('sales_persons_target')->references('config_target')
                ->on('sales_config')->onUpdate('cascade');
            $table->float('sales_persons_basic')->default(0);
            $table->foreign('sales_persons_basic')->references('config_basic')
                ->on('sales_config')->onUpdate('cascade');
            $table->float('sales_persons_mobile_bill')->default(0);
            $table->foreign('sales_persons_mobile_bill')->references('config_mobile_bill')
                ->on('sales_config')->onUpdate('cascade');
            $table->integer('sales_persons_status')->default(1);
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
        Schema::dropIfExists('sales_persons');
    }
}
