<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesSummary extends Model
{
    protected $table = 'sales_summary_report';
    protected $fillable = [
        'report_date',
        'report_year',
        'report_month',
        'report_ExecutiveCode',
        'report_ExecutiveName',
        'report_DesigCode',
        'report_DesigTitle',
        'report_dateOfjoining',
        'report_sales_persons_account_no',
        'report_sales_persons_mobile_no',
        'report_zone_id',
        'report_zone_name',
        'report_sales_persons_target',
        'basic_card_count',
        'supplementary_card_count',
        'travel_card_count',
        'virtual_card_count',
        'total_card_count',
        'to_target_commission_amount',
        'after_target_commission_amount',
        'supply_card_commission_amount',
        'travel_card_commission_amount',
        'virtual_card_commission_amount',
        'card_bonus_amount',
        'total_commission_amount',
        'report_sales_persons_basic',
        'report_basic_pay_amount',
        'report_mobile_allowance',
        'cash_reward_position',
        'cash_reward_amount',
        'report_observation_status',
        'report_observation_description',
        'grand_total_amount',
        'report_lock_status',
    ];


    /********************************************
    ## GetLastMonthsSales
     *********************************************/
    public static function GetLastMonthsSales($executiveCode,$history_year,$history_month,$count=7)
    {

        $getLastMonth_report = \App\SalesSummary::select('report_ExecutiveCode','report_year','report_month','basic_card_count')->where('report_ExecutiveCode',$executiveCode)->orderBy('id','desc')->take($count)->get();

        $last_card_report='';
        $card_grp = array();
        if(count($getLastMonth_report)>0){
            foreach ($getLastMonth_report as $key => $report){
                if($report->report_year != $history_year || $report->report_month !=$history_month){
                    $history_pad_month = str_pad($report->report_month,2,"0",STR_PAD_LEFT);
                    $month = "2019-$history_pad_month-27";

                    if($report->basic_card_count>0)
                        $card_grp[]= date('M',strtotime($month)).": ".$report->basic_card_count;
                }
            }
            $last_card_report = count($card_grp)>0? implode($card_grp,','):'';
        }
        return $last_card_report;
    }
}
