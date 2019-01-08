<?php

namespace App\Listeners;

use App\Events\SalesPersonListEvent;
use App\TaskQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SalesPersonListEventListener implements ShouldQueue
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
     * @param  SalesPersonListEvent  $event
     * @return void
     */
    public function handle(SalesPersonListEvent $event)
    {
        try{
            $salesPersonList_data = $event->salesPersonList;


            $task = isset($salesPersonList_data['task_info'])?$salesPersonList_data['task_info']:'';
            $salesPersonList = isset($salesPersonList_data['data'])?$salesPersonList_data['data']:'';

            #TaskQueue
            $task['task_start_at'] = date('Y-m-d H:i:s');
            $task_id = \App\TaskQueue::insertGetId($task);


            #SalesList
            if(!empty($salesPersonList)){

                foreach ($salesPersonList as $key => $salesPerson){
                    $person = array();

                    $salesExecutiveCode = (isset($salesPerson['SalesExecutiveCODE']) && !empty($salesPerson['SalesExecutiveCODE']))?$person['salesExecutiveCode']=$salesPerson['SalesExecutiveCODE']:'';
                    $salesExecutiveName = (isset($salesPerson['ExecutiveName']) && !empty($salesPerson['ExecutiveName']))?$person['salesExecutiveName']=$salesPerson['ExecutiveName']:'';
                    $salesDesigCode = (isset($salesPerson['DesignationCODE']) && !empty($salesPerson['DesignationCODE']))?$person['salesDesigCode']=$salesPerson['DesignationCODE']:'';
                    $sales_persons_account_no = (isset($salesPerson['account_no']) && !empty($salesPerson['account_no']))?$person['account_no']=$salesPerson['account_no']:'';

                    $dateOfJoining = (isset($salesPerson['date_of_joining']) && !empty($salesPerson['date_of_joining']))?$person['dateOfJoining']=date('Y-m-d',strtotime($salesPerson['date_of_joining'])):'';

                    $sales_persons_zone_name = (isset($salesPerson['zone_id']) && !empty($salesPerson['zone_id']))?$person['sales_persons_zone_name']=$salesPerson['zone_id']:'';

                    $zone_info = \App\SalesZone::where('zone_name',$person['sales_persons_zone_name'])->first();

                    $sales_persons_zone_id = (isset($zone_info->id) && !empty($zone_info->id))?$person['sales_persons_zone_id']=$zone_info->id:'';


                    if(isset($person['salesDesigCode'])&& !empty($person['salesDesigCode'])){

                        $config_info = \App\SalesConfig::where('designationCode',$person['salesDesigCode'])->first();
                        $salesDesigTitle = (isset($config_info->designationTitle) && !empty($config_info->designationTitle))?$person['salesDesigTitle']=$config_info->designationTitle:'';
                        $sales_persons_target = (isset($config_info->config_target))?$person['sales_persons_target']=$config_info->config_target:'';
                        $sales_persons_basic = (isset($config_info->config_basic) && !empty($config_info->config_basic))?$person['sales_persons_basic']=$config_info->config_basic:'';

                        $sales_persons_mobile_bill = (isset($config_info->config_mobile_bill))?$person['sales_persons_mobile_bill']=$config_info->config_mobile_bill:'';
                    }

                    if(isset($person['salesExecutiveCode'])&&isset($person['salesExecutiveName'])&&isset($person['dateOfJoining'])&&isset($person['sales_persons_zone_id'])&&isset($person['salesDesigCode']) && isset($person['salesDesigTitle'])){

                        $insert = \App\SalesPerson::firstOrCreate(['salesExecutiveCode'=>$person['salesExecutiveCode']],$person);

                        $event_message = json_encode($insert);
                        \App\System::EventLogWrite('insert_sales_person',$event_message);

                    }


                }
            }


            #Task Update
            \DB::table('task_queue')->where('id',$task_id)->update(['task_stop_at'=>date('Y-m-d H:i:s'),'task_status'=>2]);
            $message = "Task ID: ".$task_id." | list data ".json_encode($salesPersonList_data);
            \App\System::CustomLogWritter("listenerlog","sales_personlist_event_listener_log",$message);

        }catch (\Exception $e){
            #Task Update
            \DB::table('task_queue')->where('id',$task_id)->update(['task_stop_at'=>date('Y-m-d H:i:s'),'task_status'=>3]);
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            \App\System::CustomLogWritter("listenerlog","listener_error_log",$message);
        }


    }
}
