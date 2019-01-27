<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class AdminController extends Controller
{
    /**
     * Class constructor.
     * get current route name for page title
     *
     * @param Request $request;
     */
    public function __construct(Request $request)
    {
        $this->page_title = \Request::route()->getName();
        \App\System::AccessLogWrite();
    }

    public function index()
    {
        $data['page_title'] = $this->page_title;
        return view('user-profile.index', $data);
    }

    public function DashboardPage(){

        //var_dump(\Auth::user()->can($this->page_title));


        $data['page_title'] = $this->page_title;
        return view('pages.dashboard', $data);
    }
    /**
     * Display profile information
     * pass page title
     * Get User data by auth email
     * Get User meta data by joining user
     * Get Products by auth user.
     *
     * @return HTML view Response.
     */
    public function Profile()
    {

        $data['page_title'] = $this->page_title;

        if (isset($_REQUEST['tab']) && !empty($_REQUEST['tab'])) {
            $tab = $_REQUEST['tab'];
        } else {
            $tab = 'panel_overview';
        }
        $data['tab'] = $tab;
        $last_login = (\Session::has('last_login')) ? \Session::get('last_login') : date('Y-m-d H:i:s');
        $data['last_login'] = \App\User::TiemElapasedString($last_login);
        $user_info = \DB::table('users')
            ->where('email', \Auth::user()->email)
            ->first();
        $data['user_info'] = $user_info;
        return view('user-profile.profile',$data);
    }

    /**
     * Update User Profile
     * if user meta data exist then update else insert user meta data.
     *
     * @param  Request  $request
     * @return Response
     */
    public function ProfileUpdate(Request $request)
    {
        $user_id = \Auth::user()->id;
        $user = \DB::table('users')->where('id', $user_id)->first();
        $v = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $now = date('Y-m-d H:i:s');
        if (!empty($request->file('image_url'))) {
            $image = $request->file('image_url');
            $img_location = $image->getRealPath();
            $img_ext = $image->getClientOriginalExtension();
            $user_profile_image = \App\User::UserImageUpload($img_location, $request->input('email'), $img_ext);
            $user_profile_image = $user_profile_image;
        } else {
            $user_profile_image = $user->user_profile_image;
        }
        $user_info_update_data = array(
            'name' => ucwords($request->input('name')),
            'email' => $request->input('email'),
            'user_mobile' => $request->input('user_mobile'),
            'user_profile_image' => $user_profile_image,
            'updated_at' => $now,
        );
        try {
            \DB::table('users')->where('id', $user_id)->update($user_info_update_data);
            return redirect('me/profile')->with('message',"Profile updated successfully");
        } catch (\Exception $e) {
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            return redirect('me/profile')->with('errormessage',"Something is wrong!");
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function ProfileImageUpdate(Request $request)
    {
        if (!empty($request->file('image_url'))) {
            $email=\Auth::user()->email;
            $image = $request->file('image_url');
            $img_location=$image->getRealPath();
            $img_ext=$image->getClientOriginalExtension();
            $user_profile_image=\App\User::UserImageUpload($img_location, $email, $img_ext);
            $user_profile_image=$user_profile_image;
            $user_new_img = array(
                'user_profile_image' => $user_profile_image,
            );
            try {
                \DB::table('users')
                    ->where('id', \Auth::user()->id)
                    ->update($user_new_img);
                return redirect('me/profile')->with('message',"Profile updated successfully");
            } catch (\Exception $e) {
                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                return redirect('me/profile')->with('errormessage',$message);

            }
        }
    }
    /**
     * Update password for specific user
     * checked validation, if failed redirect with error message.
     *
     * @param Request $request
     * @return Response.
     */
    public function UserChangePassword(Request $request)
    {
        $now = date('Y-m-d H:i:s');

        $rules = array(
            'new_password' => 'required',
            'confirm_password' => 'required|same:confirm_password',
            'current_password' => 'required',
        );
        $validatedData = $request->validate($rules);


        $new_password = $request->input('new_password');
        $confirm_password = $request->input('confirm_password');

        if ($new_password == $confirm_password) {

            if (\Hash::check($request->input('current_password'),
                \Auth::user()->password)) {
                $update_password=array(
                    'password' => bcrypt($request->input('new_password')),
                    'updated_at' => $now
                );
                try {
                    \DB::table('users')
                        ->where('id', \Auth::user()->id)
                        ->update($update_password);
                    return redirect('me/profile')->with('message',"Password updated successfully !");
                } catch(\Exception $e) {
                    $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                    return redirect('me/profile')->with('errormessage',"Password update failed !");
                }
            } else {
                return redirect('me/profile?tab=change_password')->with('errormessage',"Current Password Doesn't Match !");
            }
        } else {
            return redirect('me/profile?tab=change_password')->with('errormessage',"Password Combination Doesn't Match !");
        }
    }

    /**
     * Show the form for creating a new user
     * pass page title.
     *
     *@return HTML view Response.
     */
    public function UserManagement()
    {

            $data['page_title'] = $this->page_title;
            if (isset($_REQUEST['tab']) && !empty($_REQUEST['tab'])) {
                $tab = $_REQUEST['tab'];
            } else {
                $tab = 'create_user';
            }
            $data['tab'] = $tab;
            $data['user_info'] = \DB::table('users')->get();
            $data['block_users'] = \DB::table('users')->where('status','deactivate')->get();
            $data['permission_list'] = Permission::all();
            $data['route_list'] = \App\System::GetAllRouteNameListWithPrefix('sales');

            //var_dump($data['route_list']);

            //$data['admins'] = \DB::table('users')->where('user_type','admin')->get();
            return view('user-profile.user-management',$data);
    }
    /**
     * Creating new User
     * insert user meta data if data input else insert null to user meta table.
     *
     * @param  Request  $request
     * @return Response
     */
    public function CreateUser(Request $request)
    {
        if ((\Auth::user()->user_type=="admin")) {
            $v = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'user_mobile' => 'required',
                'user_type' => 'required',
                'user_role' => 'required',
                'password' => 'required',
                'confirm_password' => 'required',
            ]);
            if ($v->fails()) {
                return redirect()->back()->withErrors($v)->withInput();
            }
            if ($request->input('password') == $request->input('confirm_password')) {
                $now=date('Y-m-d H:i:s');
                $slug=explode(' ', strtolower($request->input('name')));
                $name_slug=implode('.', $slug);
                if (!empty($request->file('image_url'))) {
                    $image = $request->file('image_url');
                    $img_location = $image->getRealPath();
                    $img_ext = $image->getClientOriginalExtension();
                    $user_profile_image = \App\Admin::UserImageUpload($img_location, $request->input('email'), $img_ext);
                } else {
                    $user_profile_image='';
                }
                $user_insert_data=array(
                    'name' => ucwords($request->input('name')),
                    'name_slug' => $name_slug,
                    'user_type' => $request->input('user_type'),
                    'user_role' => $request->input('user_role'),
                    'email' => $request->input('email'),
                    'user_mobile' => $request->input('user_mobile'),
                    'password' => bcrypt($request->input('password')),
                    'user_profile_image' => $user_profile_image,
                    'login_status' => 0,
                    'status' => "deactivate",
                    'created_at' => $now,
                    'updated_at' => $now,
                );
                try {
                    \DB::table('users')->insert($user_insert_data);
                    return redirect('admin/user/management')->with('message',"User Account Created Successfully !");
                } catch(\Exception $e) {
                    $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                    return redirect('admin/user/management')->with('errormessage',"User Already Exist !");
                }
            } else {
                return redirect('admin/user/management')->with('errormessage',"Password Does Not Matched");
            }
        } else {
            return redirect('admin/dashboard')->with('errormessage',"Request Wrong Url !");
        }
    }

    /**
     * Change status for individual user.
     *
     * @param int $user_id
     * @param int $status.
     *
     * @return Response.
     */
    public function ChangeUserStatus($user_id, $status)
    {
        $now = date('Y-m-d H:i:s');
        $update = \DB::table('users')
            ->where('id',$user_id)
            ->update(array(
                'status' => $status,
                'updated_at' => $now
            ));
        if($update) {
            echo 'User update successfully.';
        } else {
            echo 'User did not update.';
        }
    }

    /**********************************************************
    ## TaskQueueView
     *************************************************************/

    public function TaskQueueView()
    {
        $task_list = \App\TaskQueue::OrderBy('created_at','desc')->paginate(10);
        $task_list->setPath(url('/sales/task-queue/view'));
        $task_list_pagination = $task_list->render();
        $data['pagination']= $task_list_pagination;
        $data['perPage'] = $task_list->perPage();
        $data['task_list']= $task_list;

        $data['page_title'] = $this->page_title;
        return \View::make('task.task-queue-view',$data);
    }

    /********************************************
     * ## DndAddRequest
     *********************************************/

    public function DndAddRequest(){

        try{

            $msisdn = (isset($_REQUEST['msisdn'])&&!empty($_REQUEST['msisdn']))? $_REQUEST['msisdn']:'';
            $NotifyType = (isset($_REQUEST['notifyType'])&&!empty($_REQUEST['notifyType']))? $_REQUEST['notifyType']:'';


            $now = date('Y-m-d H:i:s');

            if(!empty($msisdn)&&!empty($NotifyType)&&($msisdn != "NO_MSISDN")){

                $formatted_msisdn = '880'.substr($msisdn, -10);
                $page_url   = \Request::fullUrl();

                if(strtolower($NotifyType)=='add'){

                    $SyncReq['msisdn'] = $formatted_msisdn;

                    $SyncReq_update = \App\CineDND::firstOrCreate(
                        [
                            'msisdn' =>$formatted_msisdn,
                        ],
                        $SyncReq
                    );

                    $message = $formatted_msisdn.'| NotifyType '.$NotifyType.' | URL '.$page_url;

                    \App\System::CustomLogWritter("DNDlog","dnd_sync_log",$message);


                    return "OK";
                }elseif(strtolower($NotifyType)=='remove'){

                    \App\CineDND::where('msisdn',$formatted_msisdn)->delete();

                    $message = $formatted_msisdn.'| NotifyType '.$NotifyType.' | URL '.$page_url;
                    \App\System::CustomLogWritter("DNDlog","dnd_sync_log",$message);
                    return "OK";


                }else{
                    $message = $formatted_msisdn.'| NotifyType '.$NotifyType.' | URL '.$page_url;
                    \App\System::CustomLogWritter("DNDlog","dnd_sync_error_log",$message);
                    return "invalid";
                }


            }else return "MSISDN AND NotifyType Required.";

        }catch (\Exception $e) {

            $message = "Message : " . $e->getMessage() . ", File : " . $e->getFile() . ", Line : " . $e->getLine();
            \App\System::ErrorLogWrite($message);
            return "exception";
        }

    }

    /********************************************
    ## Promo Pack Create View
     *********************************************/
    public function promoPackCreate()
    {
        $data['page_title'] = $this->page_title;
        return view('promoPack.promoPack-create',$data);
    }

    /********************************************
    ## Promo Sms Store
     *********************************************/
    public function promoPackStore(Request $request)
    {
        echo "Done";
    }


}