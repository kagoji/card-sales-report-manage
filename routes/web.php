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
/*################
    # Basic Auth
    ##################*/
Route::get('/',array('as'=>'Sign in', 'uses' =>'SystemAuthController@authLogin'));
Route::get('/auth',array('as'=>'Sign in', 'uses' =>'SystemAuthController@authLogin'));
Route::post('/auth',array('as'=>'Sign in' , 'uses' =>'SystemAuthController@authPostLogin'));
Route::post('auth/registration',array('as'=>'Registration' , 'uses' =>'SystemAuthController@authRegistration'));
Route::post('auth/forget/password',array('as'=>'Forgot Password' , 'uses' =>'SystemAuthController@authForgotPasswordConfirm'));
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
#UserManagement
Route::get('/user/management',array('as'=>'User Management' , 'uses' =>'AdminController@UserManagement'));
#CreateUser
Route::post('/user/create',array('as'=>'Create User' , 'uses' =>'AdminController@CreateUser'));
#ChangeUserStatus
Route::get('/change/user/status/{user_id}/{status}',array('as'=>'Change User Status' , 'uses' =>'AdminController@changeUserStatus'));


/*################
# ACL Settings
##################*/

Route::get('/acl-settings',array('as'=>'ACL Settings' , 'uses' =>'AclController@AclSettingsPage'));

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

        Route::get('report',array('as'=>'Sales Dashboard' , 'uses' =>'AdminController@DashboardPage'));
        Route::get('/role-type/create',array('as'=>'sales Role Type Create' , 'uses' =>'AclController@CreateRoleType'));
        Route::get('report2',array('as'=>'Sales Dashboard 22' , 'uses' =>'AdminController@DashboardPage'));


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

    var_dump(Permission::all());


});



