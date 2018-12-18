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
    ## CreateRoleType
     *********************************************/
    public function CreateRoleType()
    {
        /*$data['page_title'] = $this->page_title;
        return view('acl.settings..create-role-type',$data);*/
        $users = \App\User::role('root')->get();


        //$user->givePermissionTo(\Request::route()->getName());

        ///$users = \App\User::permission('Role Type Create')->get();

        var_dump($users);

        echo "done";


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
