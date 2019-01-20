<?php

namespace App\Listeners;

use App\Events\SummaryReportGenerateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SummaryReportGenerateEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SummaryReportGenerateEvent  $event
     * @return void
     */
    public function handle(SummaryReportGenerateEvent $event)
    {
        try{
            $reportGenerate_data = $event->reportGenerate;


            $task = isset($reportGenerate_data['task_info'])?$reportGenerate_data['task_info']:'';
            $history_year = isset($reportGenerate_data['history_year'])?$reportGenerate_data['history_year']:'';
            $history_month = isset($reportGenerate_data['history_month'])?$reportGenerate_data['history_month']:'';

            #TaskQueue
            $task['task_start_at'] = date('Y-m-d H:i:s');
            $task_id = \App\TaskQueue::insertGetId($task);

            #SalesList
            if(empty($history_year) || empty($history_month))
                throw new \Exception("Reporting Month or Year is Missing");

                $getAllSalesPerson= \App\SalesPerson::where('sales_persons_status',1)->get();

            if(count($getAllSalesPerson)==0)
                throw new \Exception("Sales Person List is not available");


            $transactionExits = \App\SalesTransaction::where('transaction_year',$history_year)->where('transaction_month',$history_month)->paginate(10);

            if(count($transactionExits)==0)
                throw new \Exception("Sales Transaction List is not available");

            #RewardLimit
            $reward_card_limit = \App\SettingsMeta::CardMetaValue('reward_card_limit');
            $reward_card_limit = !empty($reward_card_limit)?$reward_card_limit:30;

            #top_count
            $card_topper_count = \App\SettingsMeta::CardMetaValue('card_topper_count');
            $card_topper_count = !empty($card_topper_count)?$card_topper_count:3;

            #RewardAmount
            $cash_reward_amount = \App\SettingsMeta::CardMetaValue('cash_reward_amount');
            $cash_reward_amount = !empty($cash_reward_amount)?explode(',',$cash_reward_amount):[3000,2000,1000];
            array_unshift($cash_reward_amount,"");
            unset($cash_reward_amount[0]);

            #joining_observation
            $joining_observation_days = \App\SettingsMeta::CardMetaValue('joining_observation_days');
            $joining_observation_days = !empty($joining_observation_days)?$joining_observation_days:60;


            #CashRewardGrp
            $cash_reward_grp = \App\SalesTransaction::SalesRewardCardCountGroup($reward_card_limit,$card_topper_count,$history_year,$history_month);


            #MainReport
            $all_report=array();
            foreach ($getAllSalesPerson as $key => $salesPerson){

                $reportdata=array();

                $getAlltransaction = \App\SalesTransaction::SalesPersonTransactionReport($salesPerson,$history_year,$history_month);
                $get_observation_status =\App\SalesPersonMeta::GetObservationStatus($salesPerson->salesExecutiveCode,$history_year,$history_month);


                #CashReward
                $reward_position = (isset($getAlltransaction['basic_card_count']) && array_search($getAlltransaction['basic_card_count'],$cash_reward_grp))?array_search($getAlltransaction['basic_card_count'],$cash_reward_grp):-1;

                $reward_amount = ($reward_position !=-1&&isset($cash_reward_amount[$reward_position]))?$cash_reward_amount[$reward_position]:0;

                #target_fillup_check
                $basic_payable='no';
                if($getAlltransaction['basic_card_count'] >= $salesPerson->sales_persons_target){
                    $basic_payable='yes';
                }else{
                    $joining_day = \App\SalesPersonMeta::RemainingDay($salesPerson->dateOfJoining,date('Y-m-d'));
                    if(($joining_day <= $joining_observation_days) || ($get_observation_status['observation_status']==1)){
                        $basic_payable='yes';
                    }
                }



                $reportdata['report_date']=date('Y-m-d');
                $reportdata['report_year']=$history_year;
                $reportdata['report_month']=$history_month;

                $reportdata['report_ExecutiveCode']= (isset($salesPerson->salesExecutiveCode)&& !empty($salesPerson->salesExecutiveCode))?$salesPerson->salesExecutiveCode:'';

                $reportdata['report_ExecutiveName']=(isset($salesPerson->salesExecutiveName)&& !empty($salesPerson->salesExecutiveName))?$salesPerson->salesExecutiveName:'';

                $reportdata['report_DesigCode']=(isset($salesPerson->salesDesigCode)&& !empty($salesPerson->salesDesigCode))?$salesPerson->salesDesigCode:'';

                $reportdata['report_DesigTitle']=(isset($salesPerson->salesDesigTitle)&& !empty($salesPerson->salesDesigTitle))?$salesPerson->salesDesigTitle:'';

                $reportdata['report_dateOfjoining']=(isset($salesPerson->dateOfJoining)&& !empty($salesPerson->dateOfJoining))?$salesPerson->dateOfJoining:'';

                $reportdata['report_sales_persons_account_no']=(isset($salesPerson->sales_persons_account_no)&& !empty($salesPerson->sales_persons_account_no))?$salesPerson->sales_persons_account_no:'';

                $reportdata['report_sales_persons_mobile_no']=(isset($salesPerson->sales_persons_mobile_no)&& !empty($salesPerson->sales_persons_mobile_no))?$salesPerson->sales_persons_mobile_no:'';


                $reportdata['report_zone_id']=(isset($salesPerson->sales_persons_zone_id)&& !empty($salesPerson->sales_persons_zone_id))?$salesPerson->sales_persons_zone_id:'';

                $reportdata['report_zone_name']=(isset($salesPerson->sales_persons_zone_name)&& !empty($salesPerson->sales_persons_zone_name))?$salesPerson->sales_persons_zone_name:'';

                $reportdata['report_sales_persons_target']=(isset($salesPerson->sales_persons_target)&& !empty($salesPerson->sales_persons_target))?$salesPerson->sales_persons_target:0;

                $reportdata['basic_card_count']=(isset($getAlltransaction['basic_card_count'])&& !empty($getAlltransaction['basic_card_count']))?$getAlltransaction['basic_card_count']:0;

                $reportdata['supplementary_card_count']=(isset($getAlltransaction['supply_card_count'])&& !empty($getAlltransaction['supply_card_count']))?$getAlltransaction['supply_card_count']:0;

                $reportdata['travel_card_count']=(isset($getAlltransaction['travel_card_count'])&& !empty($getAlltransaction['travel_card_count']))?$getAlltransaction['travel_card_count']:0;

                $reportdata['virtual_card_count']=(isset($getAlltransaction['virtual_card_count'])&& !empty($getAlltransaction['virtual_card_count']))?$getAlltransaction['virtual_card_count']:0;

                $reportdata['total_card_count']=(isset($getAlltransaction['total_card_count'])&& !empty($getAlltransaction['total_card_count']))?$getAlltransaction['total_card_count']:0;

                $reportdata['to_target_commission_amount']=(isset($getAlltransaction['to_target_commission_amount'])&& !empty($getAlltransaction['to_target_commission_amount']))?$getAlltransaction['to_target_commission_amount']:0;

                $reportdata['after_target_commission_amount']=(isset($getAlltransaction['after_target_commission_amount'])&& !empty($getAlltransaction['after_target_commission_amount']))?$getAlltransaction['after_target_commission_amount']:0;

                $reportdata['supply_card_commission_amount']=(isset($getAlltransaction['supply_card_commission_amount'])&& !empty($getAlltransaction['supply_card_commission_amount']))?$getAlltransaction['supply_card_commission_amount']:0;

                $reportdata['travel_card_commission_amount']=(isset($getAlltransaction['travel_card_commission_amount'])&& !empty($getAlltransaction['travel_card_commission_amount']))?$getAlltransaction['travel_card_commission_amount']:0;

                $reportdata['virtual_card_commission_amount']=(isset($getAlltransaction['virtual_card_commission_amount'])&& !empty($getAlltransaction['virtual_card_commission_amount']))?$getAlltransaction['virtual_card_commission_amount']:0;

                $reportdata['card_bonus_amount']=(isset($getAlltransaction['card_bonus_amount'])&& !empty($getAlltransaction['card_bonus_amount']))?$getAlltransaction['card_bonus_amount']:0;

                $reportdata['total_commission_amount']=(isset($getAlltransaction['total_commission_amount'])&& !empty($getAlltransaction['total_commission_amount']))?$getAlltransaction['total_commission_amount']:0;

                $reportdata['report_sales_persons_basic']=(isset($salesPerson->sales_persons_basic)&& !empty($salesPerson->sales_persons_basic))?$salesPerson->sales_persons_basic:0;

                $reportdata['report_basic_pay_amount']=(isset($basic_payable)&&($basic_payable=='yes'))?$salesPerson->sales_persons_basic:0;

                $reportdata['report_mobile_allowance']=(isset($salesPerson->sales_persons_mobile_bill)&& !empty($salesPerson->sales_persons_mobile_bill))?$salesPerson->sales_persons_mobile_bill:0;

                $reportdata['cash_reward_position']=($reward_position !=-1)?$reward_position:0;
                $reportdata['cash_reward_amount']=$reward_amount;
                $reportdata['report_observation_status']=(isset($get_observation_status['observation_status']))?$get_observation_status['observation_status']:0;
                $reportdata['report_observation_description']=(isset($get_observation_status['observation_desc']))?$get_observation_status['observation_desc']:'';


                #GradTotal
                $reportdata['grand_total_amount'] = $reportdata['total_commission_amount']+$reportdata['report_basic_pay_amount']+$reportdata['cash_reward_amount']+$reportdata['report_mobile_allowance'];

                #DB
                $insert_summary_report = \App\SalesSummary::updateOrCreate(
                    [
                        'report_year'=>$reportdata['report_year'],                                                                                'report_month'=>$reportdata['report_month'],
                        'report_ExecutiveCode'=>$reportdata['report_ExecutiveCode'],
                    ],$reportdata);


                $event_message = "ExecutiveCode $reportdata[report_ExecutiveCode] | History : $history_year| Month: $history_month | ReportData :".json_encode($insert_summary_report);

                \App\System::CustomLogWritter("SalesPersonCardReport","sales_person_reward_card_log",$event_message);

                $all_report[]=$reportdata;


            }

            #Task Update
            \DB::table('task_queue')->where('id',$task_id)->update(['task_stop_at'=>date('Y-m-d H:i:s'),'task_status'=>2]);
            $message = "Task ID: ".$task_id." | list data ".json_encode($all_report);
            \App\System::CustomLogWritter("listenerlog","sales_summary_report_listener_log",$message);

        }catch (\Exception $e){
            #Task Update
            \DB::table('task_queue')->where('id',$task_id)->update(['task_stop_at'=>date('Y-m-d H:i:s'),'task_status'=>3]);
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            \App\System::CustomLogWritter("listenerlog","listener_error_log",$message);
        }
    }
}
