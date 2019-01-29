@extends('layout.master')
@section('content')
    <!--SHOW ERROR MESSAGE DIV-->
    <div class="row page_row">
        <div class="col-md-12">
            @if ($errors->count() > 0 )
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <h6>The following errors have occurred:</h6>
                    <ul>
                        @foreach( $errors->all() as $message )
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ Session::get('message') }}
                </div>
            @endif
            @if (Session::has('errormessage'))
                <div class="alert alert-danger" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ Session::get('errormessage') }}
                </div>
            @endif
        </div>
    </div>
    <!--END ERROR MESSAGE DIV-->
    <div class="row ">
        <div class="col-sm-12">
            <div class="tabbable">
                <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                    @if($tab=='edit_user')
                        <li class="{{($tab=='edit_user') ? 'active' : ''}}">
                            <a data-toggle="tab" href="#edit_user">
                                Edit User
                            </a>
                        </li>
                    @else
                        <li class="{{($tab=='create_user') ? 'active' : ''}}">
                            <a data-toggle="tab" href="#create_user">
                                Create User
                            </a>
                        </li>
                    @endif
                    <li class="{{$tab=='active_user' ? 'active':''}}">
                        <a data-toggle="tab" href="#active_user">
                            Active Users
                        </a>
                    </li>
                    <li class="{{($tab=='blocked_user') ? 'active' : ''}}">
                        <a data-toggle="tab" href="#blocked_user">
                            Blocked Users
                        </a>
                    </li>

                </ul>
                <div class="tab-content">
                    <!-- PANEL FOR CREATE USER -->
                    <div id="create_user" class="tab-pane {{$tab=='create_user' ? 'active':''}}">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="user-form"  action="{{url('/user/create')}}" method="post"
                                       enctype="multipart/form-data" class="user-form">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Account Info</h3>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="firstname2" class="control-label">
                                                    Name
                                                    <span class="symbol" aria-required="true"></span>
                                                </label>
                                                <input id="first_name" type="text" placeholder="Name"
                                                       class="form-control" name="name"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="email2" class="control-label">
                                                    Email Address
                                                    <span class="symbol" aria-required="true"></span>
                                                </label>
                                                <input type="email" placeholder="email@example.com" class="form-control" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Mobile
                                                    <span class="symbol " aria-required="true"></span>
                                                </label>
                                                <input type="text" placeholder="User Mobile" class="form-control"
                                                       id="user_mobile" name="user_mobile"  >
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    User Type
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <select class="form-control search-select" name="user_type" >
                                                    <option value="" selected="selected">Please select user role</option>
                                                    @if(isset($role_list) && count($role_list)>0)
                                                        @foreach($role_list as $key => $role)
                                                            <option value="{{$role->name}}">{{strtoupper($role->name)}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Password
                                                    <span class="symbol" aria-required="true"></span>
                                                </label>
                                                <input type="password" name="password" placeholder="********"
                                                       class="form-control" id="password" value="" />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Confirm Password
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <input type="password" id="confirm_password" class="form-control" name="confirm_password"
                                                       placeholder="********" value=""   />
                                            </div>
                                            <div class="form-group">
                                                <label> User Profile Image </label>
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="fileupload-new thumbnail profile_img_size" >
                                                        <img width="150px" height="150px" src="{{asset('images/user-profile/default-avatar.png')}}" alt="">
                                                    </div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail profile_img_size"
                                                         style="line-height: 20px;">
                                                    </div>
                                                    <div class="user-edit-image-buttons">
													<span class="btn btn-light-grey btn-file">
														<span class="fileupload-new image-filechange">
                                                            <i class="fa fa-picture"></i> Select image
                                                        </span>
														<span class="fileupload-exists image-filechange">
                                                            <i class="fa fa-picture"></i> Change
                                                        </span>
														<input type="file" name="image_url" value="" />
													</span>
                                                        <a href="#" class="btn fileupload-exists btn-light-grey"
                                                           data-dismiss="fileupload">
                                                            <i class="fa fa-times"></i> Remove
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label> Access Permission </label>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td ><input type="checkbox" id="all_permission" name="all"  /></td>
                                                            <td>Permission List</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($permission_list) && count($permission_list)>0)
                                                            @foreach($permission_list as $key => $permission)
                                                                <tr>
                                                                    <td><input type="checkbox" class="" name="permission[]" value="{{$permission->name}}" /></td>
                                                                    <td>{{$permission->name}}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="2">No data available</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">

                                        </div>
                                        <div class="col-md-4 pull-right">
                                            <button class="btn btn-teal btn-block " type="submit">
                                                Register <i class="fa fa-arrow-circle-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- END PANEL FOR CREATE USER -->
                    <!-- PANEL FOR BLOCK USER -->
                    <div id="blocked_user" class="tab-pane {{$tab=='blocked_user' ? 'active':''}}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="sample-table-1">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if (!empty($block_users))
                                            @foreach ($block_users as $key => $blocked_user_list)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $blocked_user_list->name }}</td>
                                                    <td>{{ strtoupper($blocked_user_list->user_type) }}</td>
                                                    <td>{{ $blocked_user_list->email }}</td>
                                                    <td>{{ $blocked_user_list->user_mobile }}</td>
                                                    <th><span class="label label-danger btn-squared">{{ $blocked_user_list->status }}</span></th>
                                                    <td style="width:14%">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-purple"><i class="fa fa-wrench"></i> Action</button><button data-toggle="dropdown" class="btn btn-purple dropdown-toggle"><span class="caret"></span></button><ul class="dropdown-menu" role="menu">
                                                                <li>
                                                                    <a href="{{url('/user/management?action=edit&tab=edit_user&user_id='.$blocked_user_list->id)}}"
                                                                    ><i class="fa fa-pencil"></i> Edit</a>
                                                                </li>
                                                                <li>
                                                                    @if ($blocked_user_list->status !="active")
                                                                        <a class="user_status" title="Click for Active"
                                                                           data-user-id="{{$blocked_user_list->id}}" data-status="active">
                                                                            <i class="fa fa-unlock"></i> Active
                                                                        </a>
                                                                    @endif

                                                                </li>
                                                                <li>
                                                                    <a class="user-delete" data-user-id="{{$blocked_user_list->id}}">
                                                                        <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7">
                                                    <div class="alert alert-success" role="alert">
                                                        <center><h4>No Data Available !</h4></center>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PANEL FOR BLOCK USER -->
                    <!-- PANEL FOR EDIT USER -->
                    @if(isset($edit_user_info)&&!empty($edit_user_info))
                        <div id="edit_user" class="tab-pane {{$tab=='edit_user' ? 'active':''}}">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="edit_user-form"  action="{{url('/user/'.$edit_user_info->id.'/update')}}" method="post"
                                          enctype="multipart/form-data" class="user-form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Account Info</h3>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="firstname2" class="control-label">
                                                        Name
                                                        <span class="symbol" aria-required="true"></span>
                                                    </label>
                                                    <input id="first_name" type="text" placeholder="Name"
                                                           class="form-control" name="name" value="{{(isset($edit_user_info->name))?$edit_user_info->name:''}}"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email2" class="control-label">
                                                        Email Address
                                                        <span class="symbol" aria-required="true"></span>
                                                    </label>
                                                    <input type="email" value="{{(isset($edit_user_info->email))?$edit_user_info->email:''}}" class="form-control" name="email">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Mobile
                                                        <span class="symbol " aria-required="true"></span>
                                                    </label>
                                                    <input type="text" value="{{(isset($edit_user_info->user_mobile))?$edit_user_info->user_mobile:''}}" class="form-control"
                                                           id="user_mobile" name="user_mobile"  >
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        User Type
                                                        <span class="symbol" aria-required="true"></span>
                                                    </label>
                                                    <select class="form-control search-select" name="user_type">
                                                        <option value="" selected="selected"> Please select user type</option>
                                                        @if(isset($role_list) && count($role_list)>0)
                                                            @foreach($role_list as $key => $role)
                                                                <option {{(isset($edit_user_info->user_type) &&($edit_user_info->user_type==$role->name))? 'selected':''}} value="{{$role->name}}">{{strtoupper($role->name)}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label> User Profile Image </label>
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail profile_img_size" >
                                                            <img width="150px" height="150px" src="{{(isset($edit_user_info->user_profile_image) && !empty($edit_user_info->user_profile_image))?asset($edit_user_info->user_profile_image):asset('images/user-profile/default-avatar.png')}}" alt="">
                                                        </div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail profile_img_size"
                                                             style="line-height: 20px;">
                                                        </div>
                                                        <div class="user-edit-image-buttons">
													<span class="btn btn-light-grey btn-file">
														<span class="fileupload-new image-filechange">
                                                            <i class="fa fa-picture"></i> Select image
                                                        </span>
														<span class="fileupload-exists image-filechange">
                                                            <i class="fa fa-picture"></i> Change
                                                        </span>
														<input type="file" name="image_url" value="" />
													</span>
                                                            <a href="#" class="btn fileupload-exists btn-light-grey"
                                                               data-dismiss="fileupload">
                                                                <i class="fa fa-times"></i> Remove
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label> Access Permission </label>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <td ><input type="checkbox" id="all_permission" name="all"  /></td>
                                                            <td>Permission List</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php
                                                            $user_permission = isset($edit_user_info->user_permission)&& !empty(isset($edit_user_info->user_permission))? explode(',',$edit_user_info->user_permission):array();
                                                        @endphp
                                                        @if(isset($permission_list) && count($permission_list)>0)
                                                            @foreach($permission_list as $key => $permission)
                                                                <tr>
                                                                    <td><input type="checkbox" {{(in_array($permission->name,$user_permission)?'checked':'')}} name="permission[]" value="{{$permission->name}}" /></td>
                                                                    <td>{{$permission->name}}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="2">No data available</td>
                                                            </tr>
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <button class="btn btn-teal btn-block" type="submit">
                                                    Update <i class="fa fa-arrow-circle-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                @endif
                <!-- END PANEL FOR CREATE USER -->
                    <!-- PANEL FOR ADMINS -->
                    <div id="active_user" class="tab-pane {{$tab=='active_user' ? 'active':''}}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="sample-table-1">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if (!empty($active_users))
                                            @foreach ($active_users as $key => $user_list)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $user_list->name }}</td>
                                                    <td>{{ strtoupper($user_list->user_type) }}</td>
                                                    <td>{{ $user_list->email }}</td>
                                                    <td>{{ $user_list->user_mobile }}</td>
                                                    <td>
                                                        @if($user_list->status == "active")
                                                            <span class="label label-success btn-squared">{{ $user_list->status }}</span>
                                                        @else
                                                            <span class="label label-danger btn-squared">{{ $user_list->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td style="width:14%">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-purple"><i class="fa fa-wrench"></i> Action</button><button data-toggle="dropdown" class="btn btn-purple dropdown-toggle"><span class="caret"></span></button><ul class="dropdown-menu" role="menu">
                                                                <li>
                                                                    <a href="{{url('/user/management?action=edit&tab=edit_user&user_id='.$user_list->id)}}"
                                                                    ><i class="fa fa-pencil"></i> Edit</a>
                                                                </li>
                                                                <li>
                                                                    @if ($user_list->status=="active")
                                                                        <a class="user_status" title="Click for Deactive"
                                                                           data-user-id="{{$user_list->id}}" data-status="deactivate">
                                                                            <i class="fa fa-lock"></i> DeActive
                                                                        </a>
                                                                    @endif

                                                                </li>
                                                                <li>
                                                                    <a class="user-delete" data-user-id="{{$user_list->id}}">
                                                                        <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7">
                                                    <div class="alert alert-success" role="alert">
                                                        <center><h4>No Data Available !</h4></center>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('JScript')
<script>
    $(function () {
        var site_url = $('.site_url').val();
        $('#user-form').validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                user_type: {
                    required:true
                },
                password : {
                    minlength : 4,
                    required : true
                },
                confirm_password : {
                    required : true,
                    minlength : 4,
                    equalTo : "#password"
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                    element.attr("placeholder",error.text());
                }
            }
        });

        // User delete
        $('.user-delete').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('user-id');
            bootbox.dialog({
                message: "Are you sure you want to delete this User ?",
                title: "<i class='glyphicon glyphicon-trash'></i> Delete !",
                buttons: {
                    success: {
                        label: "No",
                        className: "btn-success btn-squared",
                        callback: function() {
                            $('.bootbox').modal('hide');
                        }
                    },
                    danger: {
                        label: "Delete!",
                        className: "btn-danger btn-squared",
                        callback: function() {
                            $.ajax({
                                type: 'GET',
                                url: site_url+'/user/delete/'+id,
                            }).done(function(response){
                                bootbox.alert(response,
                                    function(){
                                        location.reload(true);
                                    }
                                );
                            }).fail(function(response){
                                bootbox.alert(response);
                            })
                        }
                    }
                }
            });
        });

        $('.user_status').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('user-id');
            var value = $(this).data('status');
            if(value == "active") {
                bootbox.dialog({
                    message: "Are you sure you want to Active this user ?",
                    title: "<i class='glyphicon glyphicon-eye-open'></i> Active !",
                    buttons: {
                        danger: {
                            label: "No!",
                            className: "btn-danger btn-squared",
                            callback: function() {
                                $('.bootbox').modal('hide');
                            }
                        },
                        success: {
                            label: "Yes!",
                            className: "btn-success btn-squared",
                            callback: function() {
                                $.ajax({
                                    type: 'GET',
                                    url: site_url+'/change/user/status/'+id+'/'+value,
                                }).done(function(response){
                                    bootbox.alert(response,
                                        function(){
                                            location.reload(true);
                                        }
                                    );

                                }).fail(function(response){
                                    bootbox.alert(response);
                                })
                            }
                        }
                    }
                });
            } else {
                bootbox.dialog({
                    message: "Are you sure you want to Deactivate this user ?",
                    title: "<i class='glyphicon glyphicon-eye-close'></i> Deactivate !",
                    buttons: {
                        danger: {
                            label: "No!",
                            className: "btn-danger btn-squared",
                            callback: function() {
                                $('.bootbox').modal('hide');
                            }
                        },
                        success: {
                            label: "Yes!",
                            className: "btn-success btn-squared",
                            callback: function() {
                                $.ajax({
                                    type: 'GET',
                                    url: site_url+'/change/user/status/'+id+'/'+value,
                                }).done(function(response){
                                    bootbox.alert(response,
                                        function(){
                                            location.reload(true);
                                        }
                                    );
                                }).fail(function(response){
                                    bootbox.alert(response);
                                })
                            }
                        }
                    }
                });
            }
        });
    });
    $('#all_permission').on('click', function (e) {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

</script>
@endsection