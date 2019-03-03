<?php

namespace App\Listeners;

use App\Events\ZoneIndividualSummaryReportEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ZoneIndividualSummaryReportEventListener implements ShouldQueue
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
     * @param  ZoneIndividualSummaryReportEvent  $event
     * @return void
     */
    public function handle(ZoneIndividualSummaryReportEvent $event)
    {
        try{
            $zoneIndividualReport_data = $event->zoneIndividualReport;


            $task = isset($zoneIndividualReport_data['task_info'])?$zoneIndividualReport_data['task_info']:'';
            $sales_zone = isset($zoneIndividualReport_data['sales_zone'])?$zoneIndividualReport_data['sales_zone']:'';
            $report_year = isset($zoneIndividualReport_data['report_year'])?$zoneIndividualReport_data['report_year']:'';
            $report_month = isset($zoneIndividualReport_data['report_month'])?$zoneIndividualReport_data['report_month']:'';

            #TaskQueue
            $task['task_start_at'] = date('Y-m-d H:i:s');
            $task_id = \App\TaskQueue::insertGetId($task);


            #SalesList
            if(empty($report_year) || empty($report_month))
                throw new \Exception("Reporting Month or Year is Missing");

            $zone_info = \App\SalesZone::where('id',$sales_zone)->first();

            if(!isset($zone_info->id))
                throw new \Exception("Invalid Zone!!");


            $getAllSalesPerson= \App\SalesPerson::where('sales_persons_status',1)->where('sales_persons_zone_id',$sales_zone)->get();

            if(count($getAllSalesPerson)==0)
                throw new \Exception("Sales Person List is not available");


            $get_zone_data = array();
            foreach ($getAllSalesPerson as $key => $salesPerson){
                $person_detail = array();
                $executivecode=$salesPerson->salesExecutiveCode;
                $sales_person_summary = \App\SalesSummary::where('report_year',$report_year)->where('report_month',$report_month)->where('report_ExecutiveCode',$executivecode)->first();

                if(isset($sales_person_summary->id)){
                    $sales_person_transaction = \App\SalesTransaction::where('transaction_year',$report_year)->where('transaction_month',$report_month)->where('tran_prd_SalesExecutiveCODE',$executivecode)->get();
                    $person_detail['sales_person_transaction'] = $sales_person_transaction;
                    $person_detail['sales_person_summary'] = $sales_person_summary;
                    $person_detail['last_card_report'] = \App\SalesSummary::GetLastMonthsSales($executivecode,$report_year,$report_month);
                    $person_detail['observation_status'] = \App\SalesPersonMeta::GetObservationStatus($executivecode,$report_year,$report_month);
                    $get_zone_data[]=$person_detail;
                }

            }

            $data['get_zone_data'] = $get_zone_data;

            $pdf = \PDF::loadView('summary-reports.pdf.zone-individual-summary-pdf',$data);
            $file_name = time().'_'.str_slug($zone_info->zone_name,'_').'_individual_detail_report.pdf';
            $pdf_path = public_path().'/pdf-download/'.$file_name;
            $pdf->save($pdf_path);

            $insert_html = '<a target="_blank" href="'.url('/PDF/view').'?file-name='.$file_name.'" class="btn btn-green tooltips" data-toggle1="tooltip" title="" data-original-title="All Individual Detail Report"><i class="clip-eye" aria-hidden="true"></i> | All Individual Report View</a>';

            #Task Update
            \DB::table('task_queue')->where('id',$task_id)->update(['task_stop_at'=>date('Y-m-d H:i:s'),'task_status'=>2,'task_name'=>$insert_html]);
            $message = "Task ID: ".$task_id." | list data ".json_encode($get_zone_data);
            \App\System::CustomLogWritter("listenerlog","sales_zone_individual_summary_report_listener_log",$message);

        }catch (\Exception $e){
            #Task Update
            \DB::table('task_queue')->where('id',$task_id)->update(['task_stop_at'=>date('Y-m-d H:i:s'),'task_status'=>3]);
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            \App\System::CustomLogWritter("listenerlog","listener_error_log",$message);
        }
    }
}
