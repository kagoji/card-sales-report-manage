<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AclController extends Controller
{
    public function __construct()
    {
        $this->page_title = \Request::route()->getName();
        \App\System::AccessLogWrite();
    }

    /********************************************
    ## AclSettingsPage
     *********************************************/
    public function AclSettingsPage()
    {

        $Rolelist = \DB::table('roles')->get();
        $data['role_list'] = $Rolelist;

        $permissiolist = \DB::table('permissions')->get();
        $data['permission_list'] = $permissiolist;


        $data['page_title'] = $this->page_title;
        return view('acl.settings..index',$data);
    }

    /********************************************
    ## CreateRoleAndPermissionType
     *********************************************/
    public function CreateRoleAndPermissionType(Request $request)
    {
        $v = $request->validate([
            'add_name' => 'required',
            'add_type' => 'required',
        ]);

        try{

            if($request->input('add_type')=='role'){
                Role::findOrCreate(($request->input('add_name')));
                $message ="Role Has been added";
            }elseif ($request->input('add_type')=='permission'){
                Permission::findOrCreate(($request->input('add_name')));
                $message ="Permission Has been added";
            }else{
                $message ="Invalid Request";
            }
            return redirect('/acl-settings')->with('message',$message);

            var_dump(Role::findOrCreate(($request->input('add_name'))));
        }catch (\Exception $e) {
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            \App\System::ErrorLogWrite($message);
            return redirect('/acl-settings')->with('errormessage',"Something is wrong!");
        }

    }

    /********************************************
    ## RoleTypeInsert
     *********************************************/
    public function RoleTypeInsert(Request $request)
    {
        $data['page_title'] = $this->page_title;
        $request->validate(['name'=>'required']);

        Role::findOrCreate($request->input('name'));

        return \Redirect::to('/acl-settings')->with('message','Role has been created');
    }



    /********************************************
    ## RoleTypeInsert
     *********************************************/
    public function PermissionTypeInsert(Request $request)
    {
        $data['page_title'] = $this->page_title;
        $request->validate(['name'=>'required']);

        Permission::findOrCreate($request->input('name'));

        return \Redirect::to('/acl-settings')->with('message','Permission Type has been created');
    }


}
