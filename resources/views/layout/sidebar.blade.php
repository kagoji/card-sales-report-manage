<div class="main-navigation navbar-collapse collapse">
    <!-- start: MAIN MENU TOGGLER BUTTON -->

        <div class="navigation-toggler">
            <i class="clip-chevron-left"></i>
            <i class="clip-chevron-right"></i>
        </div>

<!-- end: MAIN MENU TOGGLER BUTTON -->
    <!-- start: MAIN NAVIGATION MENU -->
    <ul class="main-navigation-menu">
            <li class="{{isset($page_title) && ($page_title=='Dashboard') ? 'active' : ''}} ">
                <a href="{{url('dashboard')}}"><i class="clip-home-3"></i>
                    <span class="title"> Dashboard </span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="{{isset($page_title) && ($page_title=='Profile') ? 'active' : ''}} ">
                <a href="{{url('me/profile')}}"><i class="clip-user-2"></i>
                    <span class="title"> My Profile </span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="{{isset($page_title) && ($page_title=='ACL Settings') ? 'active' : ''}} ">
                <a href="{{url('/acl-settings')}}"><i class="clip-user-2"></i>
                    <span class="title"> ACL Settings </span>
                    <span class="selected"></span>
                </a>
            </li>



            <li class="{{(isset($page_title) && ((strpos($page_title,'Settings')!== false ) && (strpos($page_title,'Sales')!== false ))) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-mail-forward" aria-hidden="true"></i>
                    <span class="title">Sales Settings</span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && ((strpos($page_title,'Settings')!== false ) && (strpos($page_title,'Sales')!== false ))) ? 'block':'active'}};">
                    <li class="{{isset($page_title) && ($page_title=='Sales Settings Commission') ? 'active' : ''}} ">
                        <a href="{{url('/sales/settings-commission')}}">
                            <span class="title"> Commission Settings </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Sales Config Settings') ? 'active' : ''}} ">
                        <a href="{{url('/sales/settings-config-sales')}}">
                            <span class="title"> Sales Config Settings </span>
                            <span class="selected"></span>
                        </a>
                    </li>

                    <li class="{{isset($page_title) && ($page_title=='Sales Zone Settings') ? 'active' : ''}} ">
                        <a href="{{url('/sales/settings-zone')}}">
                            <span class="title"> Sales Zone Settings </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Sales Person Settings') ? 'active' : ''}} ">
                        <a href="{{url('/sales/settings-person-sales')}}">
                            <span class="title"> Sales Person Settings </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="{{isset($page_title) && ($page_title=='User Management') ? 'active' : ''}} ">
                <a href="javascript:void(0)"><i class="clip-user-plus"></i>
                    <span class="title"> User Management </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{url('/user/management?tab=create_user')}}">
                            <span class="title"> Create User </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/user/management?tab=blocked_user')}}">
                            <span class="title"> Blocked User </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:;">
                            User List <i class="icon-arrow"></i>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="{{url('admin/user/management?tab=admins')}}">
                                    Admins
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="{{(isset($page_title) && (strpos($page_title,'Category')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> Category </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Category') !== false) ) ? 'block':'active'}};">
                    <li class="{{isset($page_title) && ($page_title=='Add Category') ? 'active' : ''}}">
                        <a href="{{url('/category/create')}}">
                            <i class="clip-plus-circle"></i>
                            <span class="title"> Add Category </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='All Category') ? 'active' : ''}}">
                        <a href="{{url('/category/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Category List</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{(isset($page_title) && (strpos($page_title,'Country')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-globe" aria-hidden="true"></i>
                    <span class="title"> Country </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Country') !== false) ) ? 'block':'active'}};">
                    <li class="{{isset($page_title) && ($page_title=='Add Country') ? 'active' : ''}}">
                        <a href="{{url('/country/create')}}">
                            <i class="clip-plus-circle"></i>
                            <span class="title"> Add Country </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='All Country') ? 'active' : ''}}">
                        <a href="{{url('/country/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Country List</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>
    </ul>
    <!-- end: MAIN NAVIGATION MENU -->
</div>