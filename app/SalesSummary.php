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
}
