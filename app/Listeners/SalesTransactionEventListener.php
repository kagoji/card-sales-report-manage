<?php

namespace App\Listeners;

use App\Events\SalesTransactionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SalesTransactionEventListener implements ShouldQueue
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
     * @param  SalesTransactionEvent  $event
     * @return void
     */
    public function handle(SalesTransactionEvent $event)
    {
        try{
            $salesTransaction_data = $event->salesTransaction;


            $task = isset($salesTransaction_data['task_info'])?$salesTransaction_data['task_info']:'';
            $salesTransaction = isset($salesTransaction_data['data'])?$salesTransaction_data['data']:'';

            #TaskQueue
            $task['task_start_at'] = date('Y-m-d H:i:s');
            $task_id = \App\TaskQueue::insertGetId($task);

            #SalesList
            if(!empty($salesTransaction)){

                foreach ($salesTransaction as $key => $transaction){

                    $transaction_data = array();

                    $transaction_exp_id = (isset($transaction['ReportID']) && !empty($transaction['ReportID']))?$transaction_data['transaction_exp_id']=$transaction['ReportID']:'';
                    $transaction_year = (isset($transaction['ReportYear']) && !empty($transaction['ReportYear']))?$transaction_data['transaction_year']=$transaction['ReportYear']:'';
                    $transaction_month = (isset($transaction['ReportMonth']) && !empty($transaction['ReportMonth']))?$transaction_data['transaction_month']=$transaction['ReportMonth']:'';
                    $customer_id = (isset($transaction['CUST_ID']) && !empty($transaction['CUST_ID']))?$transaction_data['customer_id']=$transaction['CUST_ID']:'';
                    $customer_name = (isset($transaction['CUST_NAME']) && !empty($transaction['CUST_NAME']))?$transaction_data['customer_name']=$transaction['CUST_NAME']:'';
                    $customer_mobile  = (isset($transaction['CUST_MOBILE']) && !empty($transaction['CUST_MOBILE']))?$transaction_data['customer_mobile']=$transaction['CUST_MOBILE']:'';
                    $customer_address = (isset($transaction['CUST_ADDRESS']) && !empty($transaction['CUST_MOBILE']))?$transaction_data['customer_address']=$transaction['CUST_ADDRESS']:'';
                    $tran_prd_grp = (isset($transaction['PRODUCTGROUP']) && !empty($transaction['PRODUCTGROUP']))?$transaction_data['tran_prd_grp']=$transaction['PRODUCTGROUP']:'';
                    $customer_limit = (isset($transaction['CUSTOMERLIMIT']) && !empty($transaction['CUSTOMERLIMIT']))?$transaction_data['customer_limit']=$transaction['CUSTOMERLIMIT']:'';
                    $customer_captureDate= (isset($transaction['CAPTUREDATE']) && !empty($transaction['CAPTUREDATE']))?$transaction_data['customer_captureDate']=$transaction['CAPTUREDATE']:'';
                    $tran_prd_SalesExecutiveCODE = (isset($transaction['SALESEXECUTIVECODE']) && !empty($transaction['SALESEXECUTIVECODE']))?$transaction_data['tran_prd_SalesExecutiveCODE']=$transaction['SALESEXECUTIVECODE']:'';


                    if(isset($transaction_data['tran_prd_SalesExecutiveCODE'])){
                        $sales_person_info = \App\SalesPerson::where('salesExecutiveCode',$transaction_data['tran_prd_SalesExecutiveCODE'])->first();
                        $tran_prd_SalesExecutiveName = (isset($sales_person_info->salesExecutiveName) && !empty($sales_person_info->salesExecutiveName))?$transaction_data['tran_prd_SalesExecutiveName']=$sales_person_info->salesExecutiveName:'';
                    }

                    if(isset($transaction_data['tran_prd_grp'])){
                        $product_info = \App\SalesCommisssion::where('cmm_prd_grp',$transaction_data['tran_prd_grp'])->first();

                        $tran_prd_name= (isset($product_info->cmm_name) && !empty($product_info->cmm_name))?$transaction_data['tran_prd_name']=$product_info->cmm_name:'';
                        $tran_commission_amount = (isset($product_info->cmm_amount) && !empty($product_info->cmm_amount))?$transaction_data['tran_commission_amount']=$product_info->cmm_amount:'';

                    }


                    if(isset($transaction_data['transaction_exp_id'])&&isset($transaction_data['tran_prd_name'])&&isset($transaction_data['tran_prd_SalesExecutiveName'])){

                        $insert = \App\SalesTransaction::updateOrCreate(
                            [
                                'transaction_exp_id'=>$transaction_data['transaction_exp_id'],                                                                                'transaction_year'=>$transaction_data['transaction_year'],
                                'transaction_month'=>$transaction_data['transaction_month'],
                            ],$transaction_data);

                        $event_message = json_encode($insert);
                        \App\System::EventLogWrite('insert_sales_transaction_data',$event_message);

                    }else{
                        $event_message = json_encode($transaction_data);
                        \App\System::CustomLogWritter("listenerlog","sales_transaction_event_listener_failedlog",$event_message);
                    }


                }

            }


            #Task Update
            \DB::table('task_queue')->where('id',$task_id)->update(['task_stop_at'=>date('Y-m-d H:i:s'),'task_status'=>2]);
            $message = "Task ID: ".$task_id." | list data ".json_encode($salesTransaction);
            \App\System::CustomLogWritter("listenerlog","sales_transaction_event_listener_log",$message);

        }catch (\Exception $e){
            #Task Update
            \DB::table('task_queue')->where('id',$task_id)->update(['task_stop_at'=>date('Y-m-d H:i:s'),'task_status'=>3]);
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            \App\System::CustomLogWritter("listenerlog","listener_error_log",$message);
        }
    }
}
