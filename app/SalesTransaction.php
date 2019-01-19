<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesTransaction extends Model
{
    protected $table = 'sales_transaction';
    protected $fillable = [
        'transaction_exp_id',
        'transaction_year',
        'transaction_month',
        'customer_id',
        'customer_name',
        'customer_mobile',
        'customer_address',
        'customer_captureDate',
        'customer_limit',
        'tran_prd_grp',
        'tran_prd_name',
        'tran_commission_amount',
        'tran_prd_SalesExecutiveCODE',
        'tran_prd_SalesExecutiveName',
    ];



    /********************************************
    ## SalesPersonTransactionReport
     *********************************************/
    public static function SalesPersonTransactionReport($salesPerson,$history_year,$history_month)
    {
        $getAlltransaction = \App\SalesTransaction::where('tran_prd_SalesExecutiveCODE',$salesPerson->salesExecutiveCode)->where('transaction_year',$history_year)->where('transaction_month',$history_month)->get();

        #CountInint
        $report['basic_card_count'] =0;
        $report['supply_card_count'] =0;
        $report['travel_card_count'] =0;
        $report['virtual_card_count'] =0;
        $report['total_card_count'] =0;
        $report['to_target_count'] =0;
        $report['after_target_count'] =0;


        #Sum amountInit
        $report['to_target_commission_amount'] =0;
        $report['after_target_commission_amount'] =0;
        $report['supply_card_commission_amount'] =0;
        $report['travel_card_commission_amount'] =0;
        $report['virtual_card_commission_amount'] =0;

        if(count($getAlltransaction)>0){

            foreach ($getAlltransaction as $key => $transaction){

                $report['total_card_count'] =$report['total_card_count']+1;

                if(in_array($transaction->tran_prd_grp,\App\SettingsMeta::CardMetaGrp('supply_card_grp'))){

                    $report['supply_card_count'] =$report['supply_card_count']+1;
                    $report['supply_card_commission_amount'] = $report['supply_card_commission_amount']+$transaction->tran_commission_amount;

                }elseif(in_array($transaction->tran_prd_grp,\App\SettingsMeta::CardMetaGrp('travel_card_grp'))){

                    $report['travel_card_count'] =$report['travel_card_count']+1;
                    $report['travel_card_commission_amount'] = $report['travel_card_commission_amount']+$transaction->tran_commission_amount;

                }elseif(in_array($transaction->tran_prd_grp,\App\SettingsMeta::CardMetaGrp('virtual_card_grp'))){

                    $report['virtual_card_count'] =$report['virtual_card_count']+1;
                    $report['virtual_card_commission_amount'] = $report['virtual_card_commission_amount']+$transaction->tran_commission_amount;

                }else{

                    $report['basic_card_count'] =$report['basic_card_count']+1;


                    if($report['basic_card_count'] <=$salesPerson->sales_persons_target){
                        $report['to_target_count'] =$report['to_target_count']+1;
                        $report['to_target_commission_amount'] = $report['to_target_commission_amount']+$transaction->tran_commission_amount;
                    }else{
                        $report['after_target_count'] =$report['after_target_count']+1;
                        $report['after_target_commission_amount'] = $report['after_target_commission_amount']+$transaction->tran_commission_amount;
                    }
                }

            }
        }


        #Grand
        #top_count
        $card_bonus_increment = \App\SettingsMeta::CardMetaValue('card_bonus_increment');
        $card_bonus_increment = !empty($card_bonus_increment)? (int)$card_bonus_increment:100;

        $report['card_bonus_amount'] = $report['after_target_count']*$card_bonus_increment;
        $report['total_commission_amount'] = $report['card_bonus_amount']+$report['supply_card_commission_amount']+$report['travel_card_commission_amount']+$report['virtual_card_commission_amount']+$report['to_target_commission_amount']+$report['after_target_commission_amount'];

        $event_message = "ExecutiveCode:$salesPerson->salesExecutiveCode Name:$salesPerson->salesExecutiveName| CardReport :".json_encode($report);
        \App\System::CustomLogWritter("SalesPersonCardReport","sales_person_card_report_log",$event_message);

        return $report;

    }


    /********************************************
    ## SalesRewardCardCountGroup
     *********************************************/
    public static function SalesRewardCardCountGroup($reward_card_limit,$top_count,$history_year,$history_month)
    {

        $non_basic_card = \App\SettingsMeta::NonBasicCardGrp();

        /*$getTopGroup=\DB::select("Select count(tran_prd_SalesExecutiveCODE) as TotalCard from sales_transaction
WHERE transaction_year=$history_year and transaction_month=$history_month  group by tran_prd_SalesExecutiveCODE having TotalCard >$reward_card_limit order by TotalCard desc ");*/

        $getTopGroup = \App\SalesTransaction::select(\DB::raw('count(tran_prd_SalesExecutiveCODE) as TotalCard'))->where('transaction_year',$history_year)->where('transaction_month',$history_month)->whereNotIn('tran_prd_grp',$non_basic_card)->groupBy('tran_prd_SalesExecutiveCODE')->having('TotalCard','>',$reward_card_limit)->orderBy('TotalCard','desc')->get();


        $top_card_count = array();

        if(count($getTopGroup)>0){
            $grouped =  collect($getTopGroup)->groupBy('TotalCard');
            foreach ($grouped as $key => $max){
                if(count($top_card_count)<$top_count)
                    $top_card_count[]=$key;
            }

            array_unshift($top_card_count,"");
            unset($top_card_count[0]);
        }

        $event_message = "Reward Card Limit $reward_card_limit | History : $history_year| Month: $history_month | Top count : $top_count| CardGrp :".json_encode($top_card_count);

        \App\System::CustomLogWritter("SalesPersonCardReport","sales_person_reward_card_log",$event_message);

        return $top_card_count;
    }





}

