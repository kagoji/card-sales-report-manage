<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesSummaryReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('sales_summary_report', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('report_date');
            $table->integer('report_year')->index();
            $table->integer('report_month')->index();
            $table->string('report_ExecutiveCode')->index();
            $table->string('report_ExecutiveName');
            $table->string('report_DesigCode');
            $table->string('report_DesigTitle');
            $table->date('report_dateOfjoining');
            $table->string('report_sales_persons_account_no');
            $table->string('report_sales_persons_mobile_no');
            $table->integer('report_zone_id')->index();
            $table->string('report_zone_name')->index();
            $table->integer('report_sales_persons_target');
            $table->integer('basic_card_count');
            $table->integer('supplementary_card_count');
            $table->integer('travel_card_count');
            $table->integer('virtual_card_count');
            $table->integer('total_card_count');
            $table->float('to_target_commission_amount');
            $table->float('after_target_commission_amount');
            $table->float('supply_card_commission_amount');
            $table->float('travel_card_commission_amount');
            $table->float('virtual_card_commission_amount');
            $table->float('card_bonus_amount');
            $table->float('total_commission_amount');
            $table->float('report_sales_persons_basic');
            $table->float('report_basic_pay_amount');
            $table->float('report_mobile_allowance');
            $table->integer('cash_reward_position');
            $table->float('cash_reward_amount');
            $table->integer('report_observation_status');
            $table->integer('report_observation_description');
            $table->float('grand_total_amount');
            $table->integer('report_lock_status')->default(0);
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
        Schema::dropIfExists('sales_summary_report');
    }
}
