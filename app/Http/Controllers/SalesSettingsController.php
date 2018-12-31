<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'cmm_prd_grp_type_name' => 'required',
            'cmm_amount' => 'required|numeric',
            'action' => 'required',
        ]);


        try{
            $commission['cmm_prd_grp'] = $request->input('cmm_prd_grp');
            $commission['cmm_name'] = $request->input('cmm_name');
            $commission['cmm_prd_grp_type_name'] = $request->input('cmm_prd_grp_type_name');
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

        if($data['action']!='delete')
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


            var_dump($person);

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
}