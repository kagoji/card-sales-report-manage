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

}
