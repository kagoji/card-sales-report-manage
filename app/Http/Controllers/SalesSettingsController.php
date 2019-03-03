<?php

namespace App\Http\Controllers;

use App\TaskQueue;
use Illuminate\Http\Request;
use App\Events\SalesPersonListEvent;
use App\Events\CommissionListEvent;
use App\Events\SalesTransactionEvent;

class SalesSettingsController extends Controller
{

    public function __construct()
    {
        $this->page_title = \Request::route()->getName();
        \App\System::AccessLogWrite();
    }

    /**********************************************************
    ## CommissionSettingsPage
     *************************************************************/

    public function CommissionSettingsPage()
    {
        $SalesCommission_list = \App\SalesCommisssion::OrderBy('created_at','desc')->paginate(10);
        $SalesCommission_list->setPath(url('/sales/settings-commission'));
        $SalesCommission_list_pagination = $SalesCommission_list->render();
        $data['pagination']=$SalesCommission_list_pagination;
        $data['perPage'] = $SalesCommission_list->perPage();
        $data['SalesCommission_list']= $SalesCommission_list;

        $data['page_title'] = $this->page_title;
        return \View::make('sales-settings.sales-commission-index',$data);
    }

    /**********************************************************
    ## CommissionSettingsAjaxLoad
     *************************************************************/

    public function CommissionSettingsAjaxLoad()
    {
        $data['action'] = isset($_REQUEST['action'])? $_REQUEST['action']:'';

        if($data['action']=='edit'){
            $data['commission_id'] = isset($_REQUEST['commission_id'])? $_REQUEST['commission_id']:'';
            $data['commission_info'] = \App\SalesCommisssion::where('id',$data['commission_id'])->first();
            return \View::make('sales-settings.ajax-sales-commission',$data);

        }

        if($data['action']=='delete'){
            $data['commission_id'] = isset($_REQUEST['commission_id'])? $_REQUEST['commission_id']:'';
            $commission_delete = \App\SalesCommisssion::where('id',$data['commission_id'])->delete();
            echo "OK";
        }

        if($data['action']!='delete')
            return \View::make('sales-settings.ajax-sales-commission',$data);


    }


    /**********************************************************
    ## CommissionSettingsChangeRequest
     *************************************************************/

    public function CommissionSettingsChangeRequest(Request $request)
    {
        $v = $request->validate([
            'cmm_prd_grp' => 'required',
            'cmm_name' => 'required',
            'cmm_amount' => 'required|numeric',
            'action' => 'required',
        ]);


        try{
            $commission['cmm_prd_grp'] = $request->input('cmm_prd_grp');
            $commission['cmm_name'] = $request->input('cmm_name');
            $commission['cmm_amount'] = $request->input('cmm_amount');
            if($request->input('action')=='add'){

                $insert = \App\SalesCommisssion::firstOrCreate(['cmm_prd_grp'=>$commission['cmm_prd_grp']],$commission);
                $event_message = json_encode($insert);
                \App\System::EventLogWrite('insert',$event_message);

                return redirect('/sales/settings-commission')->with('message',"Commission Add Successfully!");
            }

            if($request->input('action')=='edit'){
                $update = \App\SalesCommisssion::updateOrCreate(['cmm_prd_grp'=>$commission['cmm_prd_grp']],$commission);
                $event_message = json_encode($update);
                \App\System::EventLogWrite('update',$event_message);
                return redirect('/sales/settings-commission')->with('message',"Commission update Successfully!");
            }

        }catch (\Exception $e) {
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            \App\System::ErrorLogWrite($message);
            return redirect('/sales/settings-commission')->with('errormessage',"Something is wrong!");
        }
    }


    /**********************************************************
    ## SalesConfigSettingsPage
     *************************************************************/

    public function SalesConfigSettingsPage()
    {
        $SalesConfig_list = \App\SalesConfig::OrderBy('created_at','desc')->paginate(10);
        $SalesConfig_list->setPath(url('/sales/settings-config-sales'));
        $SalesConfig_list_pagination = $SalesConfig_list->render();
        $data['pagination']=$SalesConfig_list_pagination;
        $data['perPage'] = $SalesConfig_list->perPage();
        $data['SalesConfig_list']= $SalesConfig_list;

        $data['page_title'] = $this->page_title;
        return \View::make('sales-settings.sales-config-index',$data);
    }

    /**********************************************************
    ## SalesConfigSettingsAjaxLoad
     *************************************************************/

    public function SalesConfigSettingsAjaxLoad()
    {
        $data['action'] = isset($_REQUEST['action'])? $_REQUEST['action']:'';

        if($data['action']=='edit'){
            $data['config_id'] = isset($_REQUEST['config_id'])? $_REQUEST['config_id']:'';
            $data['config_info'] = \App\SalesConfig::where('id',$data['config_id'])->first();

        }

        if($data['action']=='delete'){
            $data['config_id'] = isset($_REQUEST['config_id'])? $_REQUEST['config_id']:'';
            $commission_delete = \App\SalesConfig::where('id',$data['config_id'])->delete();
            echo "OK";
        }

        if($data['action']!='delete')
            return \View::make('sales-settings.ajax-sales-config',$data);


    }

    /**********************************************************
    ## SalesConfigSettingsChangeRequest
     *************************************************************/

    public function SalesConfigSettingsChangeRequest(Request $request)
    {
        $v = $request->validate([
            'designationCode' => 'required',
            'designationTitle' => 'required',
            'config_target' => 'required|numeric',
            'config_basic' => 'required|numeric',
            'config_mobile_bill' => 'required|numeric',
            'action' => 'required',
        ]);


        try{
            $config['designationCode'] = $request->input('designationCode');
            $config['designationTitle'] = $request->input('designationTitle');
            $config['config_target'] = $request->input('config_target');
            $config['config_basic'] = $request->input('config_basic');
            $config['config_mobile_bill'] = $request->input('config_mobile_bill');

            if($request->input('action')=='add'){

                $insert = \App\SalesConfig::firstOrCreate(['designationCode'=>$config['designationCode']],$config);
                $event_message = json_encode($insert);
                \App\System::EventLogWrite('insert',$event_message);

                return redirect('/sales/settings-config-sales')->with('message',"Sales Config Add Successfully!");
            }

            if($request->input('action')=='edit'){
                $update = \App\SalesConfig::updateOrCreate(['designationCode'=>$config['designationCode']],$config);
                $event_message = json_encode($update);
                \App\System::EventLogWrite('update',$event_message);
                return redirect('/sales/settings-config-sales')->with('message',"Sales Config updated Successfully!");
            }

        }catch (\Exception $e) {
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            \App\System::ErrorLogWrite($message);
            return redirect('/sales/settings-config-sales')->with('errormessage',"Something is wrong!");
        }
    }

    /**********************************************************
    ## SalesZoneSettingsPage
     *************************************************************/

    public function SalesZoneSettingsPage()
    {
        $SalesZone_list = \App\SalesZone::OrderBy('created_at','desc')->paginate(10);
        $SalesZone_list->setPath(url('/sales/settings-zone'));
        $SalesZone_list_pagination = $SalesZone_list->render();
        $data['pagination']=$SalesZone_list_pagination;
        $data['perPage'] = $SalesZone_list->perPage();
        $data['SalesZone_list']= $SalesZone_list;

        $data['page_title'] = $this->page_title;
        return \View::make('sales-settings.sales-zone-index',$data);
    }

    /**********************************************************
    ## SalesZoneSettingsAjaxLoad
     *************************************************************/

    public function SalesZoneSettingsAjaxLoad()
    {
        $data['action'] = isset($_REQUEST['action'])? $_REQUEST['action']:'';

        if($data['action']=='edit'){
            $data['zone_id'] = isset($_REQUEST['zone_id'])? $_REQUEST['zone_id']:'';
            $data['zone_info'] = \App\SalesZone::where('id',$data['zone_id'])->first();

        }

        if($data['action']=='delete'){
            $data['zone_id'] = isset($_REQUEST['zone_id'])? $_REQUEST['zone_id']:'';
            $zone_delete = \App\SalesZone::where('id',$data['zone_id'])->delete();
            echo "OK";
        }

        if($data['action']!='delete')
            return \View::make('sales-settings.ajax-sales-zone',$data);


    }


    /**********************************************************
    ## SalesZoneSettingsChangeRequest
     *************************************************************/

    public function SalesZoneSettingsChangeRequest(Request $request)
    {
        $v = $request->validate([
            'zone_name' => 'required',
            'action' => 'required',
        ]);


        try{
            $zone['zone_name'] = $request->input('zone_name');
            $zone['id'] = $request->input('zone_id');

            if($request->input('action')=='add'){

                $insert = \App\SalesZone::firstOrCreate(['zone_name'=>$zone['zone_name']],$zone);
                $event_message = json_encode($insert);
                \App\System::EventLogWrite('insert',$event_message);

                return redirect('/sales/settings-zone')->with('message',"Sales Zone Add Successfully!");
            }

            if($request->input('action')=='edit'){
                $update = \App\SalesZone::updateOrCreate(['id'=>$zone['id']],$zone);
                $event_message = json_encode($update);
                \App\System::EventLogWrite('update',$event_message);
                return redirect('/sales/settings-zone')->with('message',"Sales Zone updated Successfully!");
            }

        }catch (\Exception $e) {
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            \App\System::ErrorLogWrite($message);
            return redirect('/sales/settings-zone')->with('errormessage',"Something is wrong!");
        }
    }

    /**********************************************************
    ## SalesPersonSettingsPage
     *************************************************************/

    public function SalesPersonSettingsPage()
    {
        $SalesPerson_list = \App\SalesPerson::OrderBy('created_at','desc')->paginate(10);
        $SalesPerson_list->setPath(url('/sales/settings-person-sales'));
        $SalesPerson_list_pagination = $SalesPerson_list->render();
        $data['pagination']=$SalesPerson_list_pagination;
        $data['perPage'] = $SalesPerson_list->perPage();
        $data['SalesPerson_list']= $SalesPerson_list;

        $data['page_title'] = $this->page_title;
        return \View::make('sales-settings.sales-person-index',$data);
    }

    /**********************************************************
    ## SalesPersonSettingsAjaxLoad
     *************************************************************/

    public function SalesPersonSettingsAjaxLoad()
    {
        $data['action'] = isset($_REQUEST['action'])? $_REQUEST['action']:'';

        $data['config_list'] = \App\SalesConfig::OrderBy('created_at','desc')->get();
        $data['zone_list'] = \App\SalesZone::OrderBy('created_at','desc')->get();

        if($data['action']=='edit'){
            $data['person_id'] = isset($_REQUEST['person_id'])? $_REQUEST['person_id']:'';
            $data['person_info'] = \App\SalesPerson::where('id',$data['person_id'])->first();
            return \View::make('sales-settings.ajax-sales-person',$data);

        }

        if($data['action']=='delete'){
            $data['person_id'] = isset($_REQUEST['person_id'])? $_REQUEST['person_id']:'';
            $person_delete = \App\SalesPerson::where('id',$data['person_id'])->delete();
            echo "OK";
        }

        if($data['action']=='block' || $data['action']=='active'){
            $data['person_id'] = isset($_REQUEST['person_id'])? $_REQUEST['person_id']:'';
            $status = isset($_REQUEST['action'])&&($_REQUEST['action']=='block')? 0:1;
            $person_delete = \App\SalesPerson::where('id',$data['person_id'])->update(['sales_persons_status'=>$status,'updated_at'=>date('Y-m-d H:i:s')]);
            echo "Change";
        }

        if($data['action']!='delete' || $data['action'] !='block' || $data['action'] !='active')
            return \View::make('sales-settings.ajax-sales-person',$data);


    }

    /**********************************************************
    ## SalesPersonSettingsChangeRequest
     *************************************************************/

    public function SalesPersonSettingsChangeRequest(Request $request)
    {
        $v = $request->validate([
            'salesExecutiveCode' => 'required',
            'salesExecutiveName' => 'required',
            'salesDesigCode' => 'required',
            'dateOfJoining' => 'required|date',
            'sales_persons_account_no' => 'required|numeric',
            'sales_persons_mobile_no' => 'required|numeric',
            'sales_persons_zone_id' => 'required|numeric',
            'action' => 'required',
        ]);


        try{
            $person['salesExecutiveCode'] = $request->input('salesExecutiveCode');
            $person['salesExecutiveName'] = $request->input('salesExecutiveName');
            $person['salesDesigCode'] = $request->input('salesDesigCode');
            $person['sales_persons_mobile_no'] = $request->input('sales_persons_mobile_no');
            $config_info = \App\SalesConfig::where('designationCode',$person['salesDesigCode'])->first();

            $salesDesigTitle = (isset($config_info->designationTitle) && !empty($config_info->designationTitle))?$person['salesDesigTitle']=$config_info->designationTitle:'';
            $sales_persons_target = (isset($config_info->config_target))?$person['sales_persons_target']=$config_info->config_target:'';
            $sales_persons_basic = (isset($config_info->config_basic) && !empty($config_info->config_basic))?$person['sales_persons_basic']=$config_info->config_basic:'';

            $sales_persons_mobile_bill = (isset($config_info->config_mobile_bill))?$person['sales_persons_mobile_bill']=$config_info->config_mobile_bill:'';


            $person['dateOfJoining'] = date('Y-m-d',strtotime($request->input('dateOfJoining')));
            $person['sales_persons_account_no'] = $request->input('sales_persons_account_no');

            $person['sales_persons_zone_id'] = $request->input('sales_persons_zone_id');
            $zone_info = \App\SalesZone::where('id',$person['sales_persons_zone_id'])->first();

            $sales_persons_zone_name = (isset($zone_info->zone_name) && !empty($zone_info->zone_name))?$person['sales_persons_zone_name']=$zone_info->zone_name:'';


            if($request->input('action')=='add'){

                $insert = \App\SalesPerson::firstOrCreate(['salesExecutiveCode'=>$person['salesExecutiveCode']],$person);
                $event_message = json_encode($insert);
                \App\System::EventLogWrite('insert',$event_message);

                return redirect('/sales/settings-person-sales')->with('message',"Sales Person Add Successfully!");
            }

            if($request->input('action')=='edit'){
                $update = \App\SalesPerson::updateOrCreate(['salesExecutiveCode'=>$person['salesExecutiveCode']],$person);
                $event_message = json_encode($update);
                \App\System::EventLogWrite('update',$event_message);
                return redirect('/sales/settings-person-sales')->with('message',"Sales Person updated Successfully!");
            }

        }catch (\Exception $e) {
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            \App\System::ErrorLogWrite($message);
            return redirect('/sales/settings-person-sales')->with('errormessage',"Something is wrong!");
        }
    }

    /**********************************************************
    ## SalesCsvUploadPage
     *************************************************************/

    public function SalesCsvUploadPage()
    {
        $data['page_title'] = $this->page_title;
        return \View::make('sales-settings.sales-csv-upload',$data);
    }

    /**********************************************************
    ## SalesCsvUploadSubmit
     *************************************************************/

    public function SalesCsvUploadSubmit(Request $request)
    {
        $v = $request->validate([
            'upload_type' => 'required',
            'csv_file' => 'required|mimes:csv,txt',
        ]);


        try{
            $csvfile = $request->file('csv_file');
            $csv_location = $csvfile->getRealPath();
            $csv_ext = $csvfile->getClientOriginalExtension();

            $csv_data = \App\User::readerCSV($csv_location);
            $csv_proess_data = \App\User::csvdataprocess($csv_data);

            #Taskinfo
            $task['task_user_id']= \Auth::user()->id;
            $task['task_user_name']= \Auth::user()->name;
            $task['task_status']= 1;

            if($request->input('upload_type')=='sales_person'){



                #TaskQueue
                $task['task_name']= 'Sales Person List Import';
                $task['task_start_at'] = date('Y-m-d H:i:s');


                #EventData
                $event_data['task_info'] = $task;
                $event_data['data'] = $csv_proess_data;
                \Event::fire(new SalesPersonListEvent($event_data));
                $redirect_message = "Please Check Task Status . Current Status is Running";

            }elseif ($request->input('upload_type')=='commission_list'){
                $task['task_name']= 'Commission List Import';
                #EventData
                $event_data['task_info'] = $task;
                $event_data['data'] = $csv_proess_data;
                \Event::fire(new CommissionListEvent($event_data));
                $redirect_message = "Please Check Task Status of Commission List . Current Status is Running";

            }elseif ($request->input('upload_type')=='sales_transaction_report'){

                $task['task_name']= 'Sales Transaction Import';
                #EventData
                $event_data['task_info'] = $task;
                $event_data['data'] = $csv_proess_data;
                \Event::fire(new SalesTransactionEvent($event_data));
                $redirect_message = "Please Check Task Status of Commission List . Current Status is Running";

            }else{
                $redirect_message = "Invalid Upload Rerquest";
                return redirect('/sales/settings-csv-sales')->with('errormessage',$redirect_message);
            }



            return redirect('/sales/task-queue/view')->with('message',$redirect_message);


        }catch (\Exception $e) {
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            \App\System::ErrorLogWrite($message);
            return redirect('/sales/settings-csv-sales')->with('errormessage',"Something is wrong!");
        }
    }


    /**********************************************************
    ## SalesPersonObservationSettingsPage
     *************************************************************/

    public function SalesPersonObservationSettingsPage()
    {
        $SalesPerson_list = \App\SalesPersonMeta::where('sales_person_meta.field_name','LIKE','observation_status%')->join('sales_persons','sales_person_meta.metaExecutiveCode','=','sales_persons.salesExecutiveCode')->select('sales_persons.salesExecutiveName','sales_person_meta.*')->OrderBy('created_at','desc')->paginate(10);
        $SalesPerson_list->setPath(url('/sales/settings-person-sales-meta'));
        $SalesPerson_list_pagination = $SalesPerson_list->render();
        $data['pagination']=$SalesPerson_list_pagination;
        $data['perPage'] = $SalesPerson_list->perPage();
        $data['SalesPerson_list']= $SalesPerson_list;

        $data['page_title'] = $this->page_title;
        return \View::make('sales-settings.sales-person-observation-index',$data);
    }

    /**********************************************************
    ## SalesPersonObservationSettingsChangeRequest
     *************************************************************/

    public function SalesPersonObservationSettingsChangeRequest(Request $request)
    {
        $v = $request->validate([
            'metaExecutiveCode' => 'required',
            'meta_year' => 'required|numeric',
            'meta_month' => 'required|numeric',
            'obs_description' => 'required',
            'action' => 'required',
        ]);


        try{
            $meta_year = $request->input('meta_year');
            $meta_month = str_pad($request->input('meta_month'),2,"0",STR_PAD_LEFT);
            $metaExecutiveCode = $request->input('metaExecutiveCode');
            $obs_description = $request->input('obs_description');

            $person_info = \App\SalesPerson::where('salesExecutiveCode',$metaExecutiveCode)->first();

            if(!isset($person_info->id))
                throw new \Exception("Invalid Sales Executive Code");

            #top_count
            $observation_yearly_count = \App\SettingsMeta::CardMetaValue('observation_yearly_count');
            $observation_yearly_count = !empty($observation_yearly_count)?$observation_yearly_count:2;

            $filed_name = "observation_status_$meta_year%";
            $observation_count = \App\SalesPersonMeta::where('metaExecutiveCode',$metaExecutiveCode)->where('field_name','Like',$filed_name)->count();


            if(($observation_count)>=$observation_yearly_count)
                throw new \Exception("Yearly Observation limit $observation_yearly_count is over!");


            #MetaDataStatus
            $meta_status_filed_name = "observation_status_$meta_year"."_".$meta_month;
            $meta_status['field_name']= $meta_status_filed_name;
            $meta_status['field_value']= 'yes';
            $meta_status['metaExecutiveCode']= $metaExecutiveCode;


            #MetaDescription
            $meta_desc_filed_name = "observation_description_$meta_year"."_".$meta_month;
            $meta_desc['field_name']= $meta_desc_filed_name;
            $meta_desc['field_value']= $obs_description;
            $meta_desc['metaExecutiveCode']= $metaExecutiveCode;


            if($request->input('action')=='add'){

                $insert = \App\SalesPersonMeta::firstOrCreate(['metaExecutiveCode'=>$metaExecutiveCode,'field_name'=>$meta_status_filed_name],$meta_status);
                $insert2 = \App\SalesPersonMeta::firstOrCreate(['metaExecutiveCode'=>$metaExecutiveCode,'field_name'=>$meta_desc_filed_name],$meta_desc);


                $event_message = json_encode($insert);
                \App\System::EventLogWrite('insert',$event_message);

                return redirect('/sales/settings-person-sales-observation')->with('message',"Sales Person Observation Successfully!");
            }

            if($request->input('action')=='edit'){

                $update = \App\SalesPersonMeta::updateOrCreate(['metaExecutiveCode'=>$metaExecutiveCode,'field_name'=>$meta_status_filed_name],$meta_status);
                $update2 = \App\SalesPersonMeta::updateOrCreate(['metaExecutiveCode'=>$metaExecutiveCode,'field_name'=>$meta_desc_filed_name],$meta_desc);
                $event_message = json_encode($update);
                \App\System::EventLogWrite('update',$event_message);
                return redirect('/sales/settings-person-sales-observation')->with('message',"Sales Person Observation updated Successfully!");
            }

        }catch (\Exception $e) {
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            $redirect_message = $e->getMessage();
            \App\System::ErrorLogWrite($message);
            return redirect('/sales/settings-person-sales-observation')->with('errormessage',$redirect_message);
        }
    }

    /**********************************************************
    ## SalesPersonObservationSettingsAjaxLoad
     *************************************************************/

    public function SalesPersonObservationSettingsAjaxLoad()
    {
        $data['action'] = isset($_REQUEST['action'])? $_REQUEST['action']:'';


        if($data['action']=='edit'){
            $data['person_observation_id'] = isset($_REQUEST['person_observation_id'])? $_REQUEST['person_observation_id']:'';
            $data['observation_info'] = \App\SalesPersonMeta::where('id',$data['person_observation_id'])->first();
            return \View::make('sales-settings.ajax-sales-person-observation',$data);

        }

        if($data['action']=='delete'){
            $data['person_observation_id'] = isset($_REQUEST['person_observation_id'])? $_REQUEST['person_observation_id']:'';
            $person_delete = \App\SalesPersonMeta::where('id',$data['person_observation_id'])->delete();
            echo "OK";
        }



        if($data['action']!='delete')
            return \View::make('sales-settings.ajax-sales-person-observation',$data);


    }

    /**********************************************************
    ## SalesReportSettingsPage
     *************************************************************/

    public function SalesReportSettingsPage()
    {
        $SalesSettings_list = \App\SettingsMeta::OrderBy('created_at','desc')->paginate(10);
        $SalesSettings_list->setPath(url('/sales/settings-sales-report'));
        $SalesSettings_list_pagination = $SalesSettings_list->render();
        $data['pagination']=$SalesSettings_list_pagination;
        $data['perPage'] = $SalesSettings_list->perPage();
        $data['SalesSettings_list']= $SalesSettings_list;

        $data['page_title'] = $this->page_title;
        return \View::make('sales-settings.sales-report-settings-index',$data);
    }

    /**********************************************************
    ## SalesReportSettingsAjaxLoad
     *************************************************************/

    public function SalesReportSettingsAjaxLoad()
    {
        $data['action'] = isset($_REQUEST['action'])? $_REQUEST['action']:'';


        if($data['action']=='edit'){
            $data['report_settings_id'] = isset($_REQUEST['report_settings_id'])? $_REQUEST['report_settings_id']:'';
            $data['settings_info'] = \App\SettingsMeta::where('id',$data['report_settings_id'])->first();
            return \View::make('sales-settings.ajax-sales-report-settings',$data);

        }

        if($data['action']=='delete'){
            $data['report_settings_id'] = isset($_REQUEST['report_settings_id'])? $_REQUEST['report_settings_id']:'';
            $person_delete = \App\SettingsMeta::where('id',$data['report_settings_id'])->delete();
            echo "OK";
        }

        if($data['action']!='delete')
            return \View::make('sales-settings.ajax-sales-report-settings',$data);


    }

    /**********************************************************
    ## SalesReportSettingsChangeRequest
     *************************************************************/

    public function SalesReportSettingsChangeRequest(Request $request)
    {
        $v = $request->validate([
            'field_name' => 'required',
            'field_value' => 'required|numeric',
            'action' => 'required',
        ]);

        try{
            $meta_year = $request->input('meta_year');

            #MetaDataStatus
            $meta_status['field_name']= $request->input('field_name');
            $meta_status['field_value']= $request->input('field_value');

            $update = \App\SettingsMeta::updateOrCreate(['field_name'=>$meta_status['field_name']],$meta_status);
            $event_message = json_encode($update);
            \App\System::EventLogWrite('update',$event_message);
            return redirect('/sales/settings-sales-report')->with('message',"Sales Settings updated Successfully!");

        }catch (\Exception $e) {
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            $redirect_message = $e->getMessage();
            \App\System::ErrorLogWrite($message);
            return redirect('/sales/settings-sales-report')->with('errormessage',$redirect_message);
        }
    }
}
