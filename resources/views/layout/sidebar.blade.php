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
                <a href="{{url('/acl-settings')}}"><i class="clip-cube-2"></i>
                    <span class="title"> ACL Settings </span>
                    <span class="selected"></span>
                </a>
            </li>


            <li class="{{isset($page_title) && ($page_title=='Task Queue View') ? 'active' : ''}} ">
                <a href="{{url('/sales/task-queue/view')}}"><i class="clip-stack-2"></i>
                    <span class="title">Task Queue</span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="{{isset($page_title) && ($page_title=='Report History View') ? 'active' : ''}} ">
                <a href="{{url('/sales/report-history/view')}}"><i class="clip-stack"></i>
                    <span class="title">Report History</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="{{(isset($page_title) && ((strpos($page_title,'Settings')!== false ) && (strpos($page_title,'Sales')!== false ))) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-gears" aria-hidden="true"></i>
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

                    <li class="{{isset($page_title) && ($page_title=='Sales Person Observation Settings') ? 'active' : ''}} ">
                        <a href="{{url('/sales/settings-person-sales-observation')}}">
                            <span class="title"> Sales Person Observation </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Sales Report Settings') ? 'active' : ''}} ">
                        <a href="{{url('/sales/settings-sales-report')}}">
                            <span class="title"> Sales Report Settings </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Sales CSV Upload Settings') ? 'active' : ''}} ">
                        <a href="{{url('/sales/settings-csv-sales')}}">
                            <span class="title"> Sales CSV Upload </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{(isset($page_title) && (strpos($page_title,'Manage Sales')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="clip-folder" aria-hidden="true"></i>
                    <span class="title">Manage Reports</span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{(isset($page_title) && (strpos($page_title,'Manage Sales')!== false ))? 'block':'active'}};">
                    <li class="{{isset($page_title) && ($page_title=='Manage Sales Zone Summary Report View') ? 'active' : ''}} ">
                        <a href="{{url('/sales/manage-reports/zone-summary')}}">
                            <span class="title">Zone Summary </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Manage Sales Individual Summary Report View') ? 'active' : ''}} ">
                        <a href="{{url('/sales/manage-reports/individual-summary')}}">
                            <span class="title">Individual Summary </span>
                            <span class="selected"></span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="{{isset($page_title) && ($page_title=='User Management') ? 'active' : ''}} ">
                <a href="javascript:void(0)"><i class="clip-users"></i>
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
                        <a href="{{url('/user/management?tab=active_user')}}">
                            <span class="title"> Active User </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/user/management?tab=blocked_user')}}">
                            <span class="title"> Blocked User </span>
                        </a>
                    </li>
                </ul>
            </li>

    </ul>
    <!-- end: MAIN NAVIGATION MENU -->
</div>