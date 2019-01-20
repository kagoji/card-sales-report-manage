<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\SummaryReportGenerateEvent;

class SalesReportController extends Controller
{

    public function __construct()
    {
        $this->page_title = \Request::route()->getName();
        \App\System::AccessLogWrite();
    }

    /**********************************************************
    ## ReportHistoryView
     *************************************************************/

    public function ReportHistoryView()
    {
        $history_list = \App\ReportHistory::OrderBy('created_at','desc')->leftJoin('users','report_history.user_id','=','users.id')->select('report_history.*','users.name')->paginate(10);
        $history_list->setPath(url('/report-history/view'));
        $history_list_pagination = $history_list->render();
        $data['pagination']=$history_list_pagination;
        $data['perPage'] = $history_list->perPage();
        $data['history_list']= $history_list;

        $data['page_title'] = $this->page_title;
        return \View::make('report-history.history-index',$data);
    }

    /**********************************************************
    ## ReportHistoryAjaxLoad
     *************************************************************/

    public function ReportHistoryAjaxLoad()
    {
        $data['action'] = isset($_REQUEST['action'])? $_REQUEST['action']:'';

        if($data['action']=='edit'){
            $data['history_id'] = isset($_REQUEST['history_id'])? $_REQUEST['history_id']:'';
            $data['history_info'] = \App\ReportHistory::where('id',$data['history_id'])->first();
            return \View::make('report-history.ajax-report-history',$data);

        }

        if($data['action']=='delete'){
            $data['history_id'] = isset($_REQUEST['history_id'])? $_REQUEST['history_id']:'';
            $history_delete = \App\ReportHistory::where('id',$data['history_id'])->delete();
            echo "OK";
        }

        if($data['action']!='delete')
            return \View::make('report-history.ajax-report-history',$data);


    }

    /**********************************************************
    ## ReportHistoryChangeRequest
     *************************************************************/

    public function ReportHistoryChangeRequest(Request $request)
    {
        $v = $request->validate([
            'history_title' => 'required',
            'history_year' => 'required|numeric',
            'history_month' => 'required|numeric',
            'action' => 'required',
        ]);


        try{
            $history['history_title'] = $request->input('history_title');
            $history['history_year'] = $request->input('history_year');
            $history['history_month'] = $request->input('history_month');


            #LockCheck
            $check_lock = \App\ReportHistory::where('history_year',$history['history_year'])->where('history_month',$history['history_month'])->where('history_lock_status',1)->first();

            #TaskQueue
            $task['task_name']= $history['history_title'];
            $task['task_start_at'] = date('Y-m-d H:i:s');


            #EventData
            $event_data['task_info'] = $task;
            $event_data['history_year'] = $history['history_year'];
            $event_data['history_month'] = $history['history_month'];

            #Add
            if($request->input('action')=='add'){

                if(!isset($check_lock->id)){

                    $history['user_id']=\Auth::user()->id;
                    $insert = \App\ReportHistory::firstOrCreate(['history_year'=>$history['history_year'],'history_month'=>$history['history_month']],$history);
                    $event_message = json_encode($insert);


                    \Event::fire(new SummaryReportGenerateEvent($event_data));

                    $message = "Report of ".$history['history_month'].",".$history['history_year']."is now Processing.Please Check Task Status . Current Status is Running";

                }else{
                    $event_message = "Report of Month:".$history['history_month'].", ".$history['history_year']." is locked and it can not be processed.";
                    $message = "Report of Month:".$history['history_month'].", ".$history['history_year']." is locked and it can not be processed.";
                }

                \App\System::EventLogWrite('insert',$event_message);
                return redirect('/report-history/view')->with('message',$message);
            }

            #Update
            if($request->input('action')=='edit'){
                $history['user_id']=\Auth::user()->id;
                if(!isset($check_lock->id)){

                    $update = \App\ReportHistory::updateOrCreate(['history_year'=>$history['history_year'],'history_month'=>$history['history_month']],$history);
                    $event_message = json_encode($update);

                    if($update->wasRecentlyCreated){
                        \Event::fire(new SummaryReportGenerateEvent($event_data));
                        $message = "Report of ".$history['history_month'].",".$history['history_year']."is now Processing.";

                    }else{
                        $message = "Report of ".$history['history_month'].",".$history['history_year']." updated.";
                    }

                }else{
                    $event_message = "Report of Month:".$history['history_month'].", ".$history['history_year']." is locked and it can not be processed.";
                    $message = "Report of Month:".$history['history_month'].", ".$history['history_year']." is locked and it can not be processed.";
                }

                \App\System::EventLogWrite('update',$event_message);
                return redirect('/report-history/view')->with('message',$message);
            }

        }catch (\Exception $e) {
            $errormessage = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            \App\System::ErrorLogWrite($errormessage);
            return redirect('/report-history/viewn')->with('errormessage',"Something is wrong!");
        }
    }

    /**********************************************************
    ## SalesZoneSummaryReportView
     *************************************************************/
    public function SalesZoneSummaryReportView()
    {
        if(isset($_GET['history_year']) && !empty($_GET['history_year']) && isset($_GET['history_month']) && !empty($_GET['history_month']) && isset($_GET['sales_zone']) && !empty($_GET['sales_zone'])){

            $history_year = $_GET['history_year'];
            $history_month = $_GET['history_month'];
            $sales_zone = $_GET['sales_zone'];

            $data['zone_info'] = \App\SalesZone::where('id',$sales_zone)->first();

            $zone_summery_list = \App\SalesSummary::where('report_year',$history_year)->where('report_month',$history_month)->where('report_zone_id',$sales_zone)->orderByRaw("FIELD(report_DesigCode,'GL','DGL','DSE','TSE'),report_dateOfjoining  ASC")->get();

            /*$zone_summery_list->setPath(url('/sales/manage-reports/zone-summary'));

            $stock_summery_pagination = $zone_summery_list->appends(['history_year' => $history_year, 'history_month'=> $history_month,'sales_zone'=>$sales_zone])->render();

            $data['pagination'] = $stock_summery_pagination;
            $data['perPage'] = $zone_summery_list->perPage();*/
            $data['zone_summery_list'] = $zone_summery_list;

        }

        $data['page_title'] = $this->page_title;
        $data['sales_zone_list'] = \App\SalesZone::all();
        return \View::make('summary-reports.zone-summary-view',$data);
    }

    /**********************************************************
    ## SalesZoneSummaryReportPDFDownload
     *************************************************************/
    public function SalesZoneSummaryReportPDFDownload()
    {
        if(isset($_GET['history_year']) && !empty($_GET['history_year']) && isset($_GET['history_month']) && !empty($_GET['history_month']) && isset($_GET['sales_zone']) && !empty($_GET['sales_zone'])){

            $history_year = $_GET['history_year'];
            $history_month = $_GET['history_month'];
            $sales_zone = $_GET['sales_zone'];

            $zone_summery_list = \App\SalesSummary::where('report_year',$history_year)->where('report_month',$history_month)->where('report_zone_id',$sales_zone)->orderByRaw("FIELD(report_DesigCode,'GL','DGL','DSE','TSE'),report_dateOfjoining  ASC")->get();

            if(count($zone_summery_list)==0)
                return \Redirect::to('/sales/manage-reports/zone-summary')->with('errormessage','Zone Report is Not Available !!.');

            $zone_info = \App\SalesZone::where('id',$sales_zone)->first();

            $data['zone_summery_list'] = $zone_summery_list;
            $data['page_title'] = $this->page_title;
            $data['zone_info']= $zone_info;

            $pdf = \PDF::loadView('summary-reports.pdf.zone-summary-pdf',$data);
            $pdfname = time().'_summary_report_'.$zone_info->zone_name.'.pdf';
            return $pdf->download($pdfname);

            //return \View::make('summary-reports.pdf.zone-summary-pdf',$data);


        }else return \Redirect::to('/sales/manage-reports/zone-summary')->with('errormessage','Year/Month/Zone is missing !!.');


    }
    /**********************************************************
    ## SalesZoneSummaryReportPrint
     *************************************************************/
    public function SalesZoneSummaryReportPrint()
    {
        if(isset($_GET['history_year']) && !empty($_GET['history_year']) && isset($_GET['history_month']) && !empty($_GET['history_month']) && isset($_GET['sales_zone']) && !empty($_GET['sales_zone'])){

            $history_year = $_GET['history_year'];
            $history_month = $_GET['history_month'];
            $sales_zone = $_GET['sales_zone'];

            $zone_summery_list = \App\SalesSummary::where('report_year',$history_year)->where('report_month',$history_month)->where('report_zone_id',$sales_zone)->orderByRaw("FIELD(report_DesigCode,'GL','DGL','DSE','TSE'),report_dateOfjoining  ASC")->get();

            if(count($zone_summery_list)==0)
                return \Redirect::to('/sales/manage-reports/zone-summary')->with('errormessage','Zone Report is Not Available !!.');

            $zone_info = \App\SalesZone::where('id',$sales_zone)->first();

            $data['zone_summery_list'] = $zone_summery_list;
            $data['page_title'] = $this->page_title;
            $data['zone_info']= $zone_info;

            return \View::make('summary-reports.print.zone-summary-print',$data);


        }else return \Redirect::to('/sales/manage-reports/zone-summary')->with('errormessage','Year/Month/Zone is missing !!.');


    }

}
