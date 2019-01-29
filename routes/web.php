<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',array('as'=>'Sign in', 'uses' =>'SystemAuthController@authLogin'));
Route::get('/auth',array('as'=>'Sign in', 'uses' =>'SystemAuthController@authLogin'));
Route::post('/auth',array('as'=>'Sign in' , 'uses' =>'SystemAuthController@authPostLogin'));
Route::post('auth/registration',array('as'=>'Registration' , 'uses' =>'SystemAuthController@authRegistration'));
Route::post('auth/forget/password',array('as'=>'Forgot Password' , 'uses' =>'SystemAuthController@authForgotPasswordConfirm'));


Route::group(['middleware' => ['systemAuth_check']], function () {

    /*################
    # Basic Auth
    ##################*/


    Route::get('auth/set/new/password/{user_id}/verify',array('as'=>'Forgot Password Verify' , 'uses' =>'SystemAuthController@authSystemForgotPasswordVerification'));
    Route::post('auth/post/new/password/',array('as'=>'New Password Submit' , 'uses' =>'SystemAuthController@authSystemNewPasswordPost'));
    Route::get('auth/me/logout/{email}',array('as'=>'Logout' , 'uses' =>'SystemAuthController@authLogout'));

    /*################
    # Profile
    ##################*/
    //profile
    Route::get('/me/profile',array('as'=>'Profile' , 'uses' =>'AdminController@Profile'));
    Route::post('/me/profile/update',array('as'=>'Profile Update' , 'uses' =>'AdminController@ProfileUpdate'));
    Route::post('/me/profile/image/update',array('as'=>'Profile Image Update' , 'uses' =>'AdminController@ProfileImageUpdate'));
    Route::post('/me/change/password',array('as'=>'User Change Password' , 'uses' =>'AdminController@UserChangePassword'));



    /*################
    # Admin Auth
    ##################*/

    Route::group(['middleware' => ['adminAuth_check']], function () {

        /*################
        # User Manage
        ##################*/

        #UserManagement
        Route::get('/user/management',array('as'=>'User Management' , 'uses' =>'AdminController@UserManagement'));
        #CreateUser
        Route::post('/user/create',array('as'=>'Create User' , 'uses' =>'AdminController@CreateUser'));
        #ChangeUserStatus
        Route::get('/change/user/status/{user_id}/{status}',array('as'=>'Change User Status' , 'uses' =>'AdminController@changeUserStatus'));
        #UserDelete
        Route::get('/user/delete/{user_id}',array('as'=>'User Delete' , 'uses' =>'AdminController@UserInfoDelete'));

        #UpdateUser
        Route::post('/user/{user_id}/update',array('as'=>'Update User' , 'uses' =>'AdminController@UpdateUserInfo'));


        /*################
        # ACL Settings
        ##################*/

        Route::get('/acl-settings',array('as'=>'ACL Settings' , 'uses' =>'AclController@AclSettingsPage'));
        Route::post('/acl-settings',array('as'=>'ACL Settings' , 'uses' =>'AclController@CreateRoleAndPermissionType'));

    });




    #RoleType
    Route::get('/role-type/create',array('as'=>'Role Type Create' , 'uses' =>'AclController@CreateRoleType'));
    Route::post('/role-type/create',array('as'=>'Role Type Create' , 'uses' =>'AclController@RoleTypeInsert'));
    Route::get('/role-type/list',array('as'=>'Role Type List' , 'uses' =>'AclController@ListRoleType'));

    #PermissionType
    Route::get('/permission-type/create',array('as'=>'Permission Type Create' , 'uses' =>'AclController@CreatePermissionType'));
    Route::post('/permission-type/create',array('as'=>'Permission Type Create' , 'uses' =>'AclController@PermissionTypeInsert'));
    Route::get('/permission-type/list',array('as'=>'Permission Type List' , 'uses' =>'AclController@ListPermissionType'));





    /*################
    # Dashboard
    ##################*/

    Route::get('/dashboard',array('as'=>'Dashboard' , 'uses' =>'AdminController@DashboardPage'));

    /*################
    # Sales
    ##################*/

    Route::group(['middleware' => ['acl_check']], function () {
        Route::group(['prefix' => 'sales'], function () {

            #TaskQueue
            Route::get('/task-queue/view',array('as'=>'Sales Task Queue View' , 'uses' =>'AdminController@TaskQueueView'));

            #ReportHistory
            Route::get('/report-history/view',array('as'=>'Sales Report History View' , 'uses' =>'SalesReportController@ReportHistoryView'));
            Route::post('/report-history/view',array('as'=>'Sales Report History View' , 'uses' =>'SalesReportController@ReportHistoryChangeRequest'));
            Route::get('/report-history/ajax/view',array('as'=>'Sales Report History View' , 'uses' =>'SalesReportController@ReportHistoryAjaxLoad'));

            #SalesCommission
            Route::get('/settings-commission',array('as'=>'Sales Settings Commission' , 'uses' =>'SalesSettingsController@CommissionSettingsPage'));
            Route::post('/settings-commission',array('as'=>'Sales Settings Commission' , 'uses' =>'SalesSettingsController@CommissionSettingsChangeRequest'));
            Route::get('/settings-commission/ajax/view',array('as'=>'Sales Settings Commission' , 'uses' =>'SalesSettingsController@CommissionSettingsAjaxLoad'));

            #SalesConfig
            Route::get('/settings-config-sales',array('as'=>'Sales Config Settings' , 'uses' =>'SalesSettingsController@SalesConfigSettingsPage'));
            Route::post('/settings-config-sales',array('as'=>'Sales Config Settings' , 'uses' =>'SalesSettingsController@SalesConfigSettingsChangeRequest'));
            Route::get('/settings-config-sales/ajax/view',array('as'=>'Sales Config Settings' , 'uses' =>'SalesSettingsController@SalesConfigSettingsAjaxLoad'));


            #SalesZone
            Route::get('/settings-zone',array('as'=>'Sales Zone Settings' , 'uses' =>'SalesSettingsController@SalesZoneSettingsPage'));
            Route::post('/settings-zone',array('as'=>'Sales Zone Settings' , 'uses' =>'SalesSettingsController@SalesZoneSettingsChangeRequest'));
            Route::get('/settings-zone/ajax/view',array('as'=>'Sales Zone Settings' , 'uses' =>'SalesSettingsController@SalesZoneSettingsAjaxLoad'));

            #SalesReportSettings
            Route::get('/settings-sales-report',array('as'=>'Sales Report Settings' , 'uses' =>'SalesSettingsController@SalesReportSettingsPage'));
            Route::post('/settings-sales-report',array('as'=>'Sales Report Settings' , 'uses' =>'SalesSettingsController@SalesReportSettingsChangeRequest'));
            Route::get('/settings-sales-report/ajax/view',array('as'=>'Sales Report Settings' , 'uses' =>'SalesSettingsController@SalesReportSettingsAjaxLoad'));


            #SalesPerson
            Route::get('/settings-person-sales',array('as'=>'Sales Person Settings' , 'uses' =>'SalesSettingsController@SalesPersonSettingsPage'));
            Route::post('/settings-person-sales',array('as'=>'Sales Person Settings' , 'uses' =>'SalesSettingsController@SalesPersonSettingsChangeRequest'));
            Route::get('/settings-person-sales/ajax/view',array('as'=>'Sales Person Settings' , 'uses' =>'SalesSettingsController@SalesPersonSettingsAjaxLoad'));


            #SalesPersonMeta
            Route::get('/settings-person-sales-observation',array('as'=>'Sales Person Observation Settings' , 'uses' =>'SalesSettingsController@SalesPersonObservationSettingsPage'));
            Route::post('/settings-person-sales-observation',array('as'=>'Sales Person Observation Settings' , 'uses' =>'SalesSettingsController@SalesPersonObservationSettingsChangeRequest'));
            Route::get('/settings-person-sales-observation/ajax/view',array('as'=>'Sales Person Observation Settings' , 'uses' =>'SalesSettingsController@SalesPersonObservationSettingsAjaxLoad'));

            
            #CSV Upload
            Route::get('/settings-csv-sales',array('as'=>'Sales CSV Upload Settings' , 'uses' =>'SalesSettingsController@SalesCsvUploadPage'));
            Route::post('/settings-csv-sales',array('as'=>'Sales CSV Upload Settings' , 'uses' =>'SalesSettingsController@SalesCsvUploadSubmit'));

            #UserRole
            Route::get('/role-type/create',array('as'=>'Sales Role Type Create' , 'uses' =>'AclController@CreateRoleType'));

            #ManageSalesReport
            Route::get('/manage-reports/zone-summary',array('as'=>'Manage Sales Zone Summary Report View' , 'uses' =>'SalesReportController@SalesZoneSummaryReportView'));
            Route::get('/manage-reports/zone-summary/pdf',array('as'=>'Manage Sales Zone Summary Report View', 'uses' =>'SalesReportController@SalesZoneSummaryReportPDFDownload'));
            Route::get('/manage-reports/zone-summary/print',array('as'=>'Manage Sales Zone Summary Report View', 'uses' =>'SalesReportController@SalesZoneSummaryReportPrint'));

            #ManageIndividualReport
            Route::get('/manage-reports/individual-summary',array('as'=>'Manage Sales Individual Summary Report View' , 'uses' =>'SalesReportController@SalesIndividualSummaryReportView'));
            Route::get('/manage-reports/individual-summary/pdf',array('as'=>'Manage Sales Individual Summary Report View' , 'uses' =>'SalesReportController@SalesIndividualSummaryReportPDFDownload'));
            Route::get('/manage-reports/individual-summary/print',array('as'=>'Manage Sales Individual Summary Report View' , 'uses' =>'SalesReportController@SalesIndividualSummaryReportPrint'));

            Route::post('/manage-reports/individual-summary',array('as'=>'Manage Sales All Individual Summary Report PDF Download', 'uses' =>'SalesReportController@SalesAllIndividualSummaryReportPDFDownload'));


        });
    });


});





use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
Route::get('/acl-check',function(){
    //$user = \Auth::user();
    //$user->givePermissionTo(['edit articles', 'delete articles']);

    /*$roles = Role::create(['name' => 'root']);

    $permission = Permission::create(['name' => 'Role Type Create']);
    $roles->givePermissionTo($permission);

    var_dump($permission);
    var_dump($roles);*/


    //$user = \App\User::where('name','root')->first();
    /*$user = $user->can('Role Type Create');

    $users = \App\User::where('name','root')->permission('Role Type Create')->get();

    $role = Role::findByName('root');*/

    //$role= $user->hasRole('root');

    //$role= \Auth::user()->getRoleNames();

    /*$roles = Role::create(['name' => 'writter']);

    $permission = Permission::create(['name' => 'edit post']);*/

    //\Auth::user()->givePermissionTo('edit post');
    //\Auth::user()->assignRole('writter');
    //auth()->user()->gitvePermissionTo('edit post');
    //var_dump(\Auth::user()->permissions);


    //var_dump(\App\System::GetAllRouteNameListWithPrefix('Sales'));

    /*$user =\App\User::insert([
        'name' => 'root',
        'email' => 'root@sample.com',
        'password' => \Hash::make('123456'),
        'user_type'=>'root',
        'status'=> "active"
    ]);
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    $permissionlist =\App\System::GetAllRouteNameListWithPrefix('Sales');
    $role = Role::create(['name' => 'root']);

    foreach ($permissionlist as $permission)
        Permission::findOrCreate($permission);*/


    /*$user->givePermissionTo(Permission::all());
    $user->assignRole($role);*/

    /*$role = Role::findByName('root');

    var_dump($role);*/
    /*$role = Role::findByName('root');
    $user = \App\User::where('name','root')->first();
    $role->givePermissionTo(Permission::all());
    $user->assignRole($role->name);
    $user->givePermissionTo(Permission::all());


    var_dump($user->permissions);*/

    /*$user =\App\User::insert([
        'name' => 'root',
        'email' => 'root@sample.com',
        'password' => \Hash::make('123456'),
        'user_type'=>'root',
        'status'=> "active"
    ]);
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    $permissionlist =\App\System::GetAllRouteNameListWithPrefix('Sales');
    $role = Role::create(['name' => 'root']);

    foreach ($permissionlist as $permission)
        Permission::findOrCreate($permission);

    //$role = Role::findByName('root');
    //$user = \App\User::where('name','root')->first();
    $role->givePermissionTo(Permission::all());
    $user->assignRole('root');
    $user->givePermissionTo(Permission::all());*/

    //var_dump(Permission::all());

    //echo \Hash::make('1234');

    //var_dump(\App\System::GetAllRouteNameListWithPrefix('Sales'));

    //$user_permission = \DB::table('role_has_permissions')

    /*#AddRoleandPermission
    $role = Role::findOrCreate('admin');
    $user = \App\User::where('id',3)->first();
    $user->assignRole($role);
    $user->givePermissionTo('Sales Task Queue View');*/

    /*$user = \App\User::where('id',3)->first();
    $user->revokePermissionTo('Sales Task Queue View');

    var_dump($user);



        if( (!(\Auth::check())  && !isset(\Auth::user()->user_type)) || (\Auth::user()->user_type != "admin" && \Auth::user()->user_type != "root" ))
            echo \Auth::user()->user_type;
        else echo "Not";*/

    #AddRoleandPermission
    //$role = Role::findOrCreate('admin');
    $user = \App\User::where('id',11)->first();
    //$user->assignRole($role);
    //$user->givePermissionTo('Sales Task Queue View');

    ///var_dump($user->givePermissionTo('Sales Task Queue View'));




});

use App\DateTime;
Route::get('/report-check',function (){

    $history_year = 2018;
    $history_month = 12;


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


    $getAllSalesPerson= \App\SalesPerson::where('sales_persons_status',1)->get();
    foreach ($getAllSalesPerson as $key => $salesPerson){

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





    }

});

Route::get('/all-downloand',function () {
    //$executivecode = '437';
    /*$report_year = 2018;
    $report_month = 12;
    $zone_id=3;

    $getAllSalesPerson= \App\SalesPerson::where('sales_persons_status',1)->where('sales_persons_zone_id',$zone_id)->get();
    $get_zone_data = array();
    foreach ($getAllSalesPerson as $key => $salesPerson){
        $person_detail = array();
        $executivecode=$salesPerson->salesExecutiveCode;
        $sales_person_summary = \App\SalesSummary::where('report_year',$report_year)->where('report_month',$report_month)->where('report_ExecutiveCode',$executivecode)->first();

        if(!isset($sales_person_summary->id))
            return \Redirect::back()->with('errormessage','Sales person Report is Not Available !!.');

        $sales_person_transaction = \App\SalesTransaction::where('transaction_year',$report_year)->where('transaction_month',$report_month)->where('tran_prd_SalesExecutiveCODE',$executivecode)->get();
        $last_card_report = \App\SalesSummary::GetLastMonthsSales($executivecode,$report_year,$report_month);
        $person_detail['sales_person_transaction'] = $sales_person_transaction;
        $person_detail['sales_person_summary'] = $sales_person_summary;
        $person_detail['last_card_report'] = \App\SalesSummary::GetLastMonthsSales($executivecode,$report_year,$report_month);
        $person_detail['observation_status'] = \App\SalesPersonMeta::GetObservationStatus($executivecode,$report_year,$report_month);

        $get_zone_data[]=$person_detail;
    }

    $data['get_zone_data'] = $get_zone_data;

    return \View::make('summary-reports.pdf.zone-individual-summary-pdf',$data);*/


    echo storage_path()."And";



    //var_dump($get_zone_data);

});




