<?php

namespace App\Listeners;

use App\Events\CommissionListEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommissionListEventListener implements ShouldQueue
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
     * @param  CommissionListEvent  $event
     * @return void
     */
    public function handle(CommissionListEvent $event)
    {
        try{
            $commissionList_data = $event->commissionList;


            $task = isset($commissionList_data['task_info'])?$commissionList_data['task_info']:'';
            $commissionList = isset($commissionList_data['data'])?$commissionList_data['data']:'';

            #TaskQueue
            $task['task_start_at'] = date('Y-m-d H:i:s');
            $task_id = \App\TaskQueue::insertGetId($task);

            #SalesList
            if(!empty($commissionList)){

                foreach ($commissionList as $key => $commission){
                    $commission_info = array();

                    $cmm_prd_grp = (isset($commission['prd_grp']) && !empty($commission['prd_grp']))?$commission_info['cmm_prd_grp']=$commission['prd_grp']:'';
                    $cmm_name = (isset($commission['comm_name']) && !empty($commission['comm_name']))?$commission_info['cmm_name']=$commission['comm_name']:'';
                    $cmm_amount = (isset($commission['comm_amount']) && !empty($commission['comm_amount']))?$commission_info['cmm_amount']=$commission['comm_amount']:'';


                    if(isset($commission_info['cmm_prd_grp'])&&isset($commission_info['cmm_name'])&&isset($commission_info['cmm_amount'])){

                        $insert = \App\SalesCommisssion::firstOrCreate(['cmm_prd_grp'=>$commission_info['cmm_prd_grp']],$commission_info);

                        $event_message = json_encode($insert);
                        \App\System::EventLogWrite('insert_commission_data',$event_message);

                    }


                }
            }


            #Task Update
            \DB::table('task_queue')->where('id',$task_id)->update(['task_stop_at'=>date('Y-m-d H:i:s'),'task_status'=>2]);
            $message = "Task ID: ".$task_id." | list data ".json_encode($commissionList_data);
            \App\System::CustomLogWritter("listenerlog","sales_commission_event_listener_log",$message);

        }catch (\Exception $e){
            #Task Update
            \DB::table('task_queue')->where('id',$task_id)->update(['task_stop_at'=>date('Y-m-d H:i:s'),'task_status'=>3]);
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            \App\System::CustomLogWritter("listenerlog","listener_error_log",$message);
        }
    }
}
