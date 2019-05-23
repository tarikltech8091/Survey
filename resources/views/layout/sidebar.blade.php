<div class="main-navigation navbar-collapse collapse">
    <!-- start: MAIN MENU TOGGLER BUTTON -->
    <div class="navigation-toggler">
        <i class="clip-chevron-left"></i>
        <i class="clip-chevron-right"></i>
    </div>
    <!-- end: MAIN MENU TOGGLER BUTTON -->
    <!-- start: MAIN NAVIGATION MENU -->
    <ul class="main-navigation-menu">
        @if(\Auth::user()->user_role == "admin")
            <li class="{{isset($page_title) && ($page_title=='Dashboard') ? 'active' : ''}} ">
                <a href="{{url('dashboard')}}"><i class="clip-home-3"></i>
                    <span class="title"> Dashboard </span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="{{isset($page_title) && ($page_title=='Profile') ? 'active' : ''}} ">
                <a href="{{url('admin/profile')}}"><i class="clip-user-2"></i>
                    <span class="title"> My Profile </span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="{{(isset($page_title) && (strpos($page_title,'User')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> User Management </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{url('admin/user/management?tab=create_user')}}">
                            <span class="title"> Create User </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/user/management?tab=blocked_user')}}">
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
                                    All Users
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
                    <li class="{{isset($page_title) && ($page_title=='Category List') ? 'active' : ''}}">
                        <a href="{{url('/category/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Category List</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="{{(isset($page_title) && (strpos($page_title,'Zone')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> Zone </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Zone') !== false) ) ? 'block':'active'}};">
                    <li class="{{isset($page_title) && ($page_title=='Add Zone') ? 'active' : ''}}">
                        <a href="{{url('/zone/create')}}">
                            <i class="clip-plus-circle"></i>
                            <span class="title"> Add Zone </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Zone List') ? 'active' : ''}}">
                        <a href="{{url('/zone/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Zone List</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="{{(isset($page_title) && (strpos($page_title,'Surveyer')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> Surveyer </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Surveyer') !== false) ) ? 'block':'active'}};">
                    <li class="{{isset($page_title) && ($page_title=='Add Surveyer') ? 'active' : ''}}">
                        <a href="{{url('/surveyer/create')}}">
                            <i class="clip-plus-circle"></i>
                            <span class="title"> Add Surveyer </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Surveyer List') ? 'active' : ''}}">
                        <a href="{{url('/surveyer/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Surveyer List</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                    <li class="{{isset($page_title) && ($page_title=='Surveyer Assign') ? 'active' : ''}}">
                        <a href="{{url('/surveyer/assign')}}">
                            <i class="clip-plus-circle"></i>
                            <span class="title"> Surveyer Assign </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Surveyer Assign List') ? 'active' : ''}}">
                        <a href="{{url('/surveyer/assign/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Surveyer Assign List</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                </ul>
            </li>



            <li class="{{(isset($page_title) && (strpos($page_title,'Requester')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> Requester </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Requester') !== false) ) ? 'block':'active'}};">
                    <li class="{{isset($page_title) && ($page_title=='Add Requester') ? 'active' : ''}}">
                        <a href="{{url('/requester/create')}}">
                            <i class="clip-plus-circle"></i>
                            <span class="title"> Add Requester </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Requester List') ? 'active' : ''}}">
                        <a href="{{url('/requester/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Requester List</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>



            <li class="{{(isset($page_title) && (strpos($page_title,'Campaign')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> Campaign </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Campaign') !== false) ) ? 'block':'active'}};">
                    <li class="{{isset($page_title) && ($page_title=='Campaign Create') ? 'active' : ''}}">
                        <a href="{{url('/campaign/create')}}">
                            <i class="clip-plus-circle"></i>
                            <span class="title"> Add Campaign </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    
                    <li class="{{isset($page_title) && ($page_title=='Campaign List') ? 'active' : ''}}">
                        <a href="{{url('/campaign/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Campaign List</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                    <li class="{{isset($page_title) && ($page_title=='Active Campaign List') ? 'active' : ''}}">
                        <a href="{{url('/participate/campaign/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Active Campaign List</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                    <li class="{{isset($page_title) && ($page_title=='Campaign Payment') ? 'active' : ''}}">
                        <a href="{{url('/campaign/payment')}}">
                            <i class="clip-plus-circle"></i>
                            <span class="title"> Add Campaign Payment </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Campaign Payment List') ? 'active' : ''}}">
                        <a href="{{url('/campaign/payment/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Campaign Payment List</span>
                            <span class="selected"></span>
                        </a>
                    </li>


                    <li class="{{isset($page_title) && ($page_title=='Campaign Survey Countdown') ? 'active' : ''}}">
                        <a href="{{url('/admin/campaign/participate/countdown')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Campaign Survey Countdown</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                </ul>
            </li>

            
        

            <li class="{{(isset($page_title) && (strpos($page_title,'Question')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> Question </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Question') !== false) ) ? 'block':'active'}};">
                    <li class="{{isset($page_title) && ($page_title=='Add Question') ? 'active' : ''}}">
                        <a href="{{url('/question/create')}}">
                            <i class="clip-plus-circle"></i>
                            <span class="title"> Add Question </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='All Question Content List') ? 'active' : ''}}">
                        <a href="{{url('/question/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Question List</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Question Answer List') ? 'active' : ''}}">
                        <a href="{{url('/question/answer/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Question Answer List</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                </ul>
            </li>



            <!-- <li class="{{(isset($page_title) && (strpos($page_title,'Participate')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> Participate </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Participate') !== false) ) ? 'block':'active'}};">
                    <li class="{{isset($page_title) && ($page_title=='Add Participate') ? 'active' : ''}}">
                        <a href="{{url('/participate/create')}}">
                            <i class="clip-plus-circle"></i>
                            <span class="title"> Add Participate </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Participate List') ? 'active' : ''}}">
                        <a href="{{url('/participate/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Participate List</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li> -->



            <li class="{{(isset($page_title) && (strpos($page_title,'Earn')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> Earn  </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Earn') !== false) ) ? 'block':'active'}};">
                    <li class="{{isset($page_title) && ($page_title=='Earn Payment') ? 'active' : ''}}">
                        <a href="{{url('/earn/payment')}}">
                            <i class="clip-plus-circle"></i>
                            <span class="title"> Add Earn </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Earn Payment List') ? 'active' : ''}}">
                        <a href="{{url('/earn/payment/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Earn List</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>

        @elseif(\Auth::user()->user_role == "requester")

            <li class="{{isset($page_title) && ($page_title=='Dashboard') ? 'active' : ''}} ">
                <a href="{{url('dashboard')}}"><i class="clip-home-3"></i>
                    <span class="title"> Dashboard </span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="{{isset($page_title) && ($page_title=='Profile') ? 'active' : ''}} ">
                <a href="{{url('/requester/profile')}}"><i class="clip-user-2"></i>
                    <span class="title"> My Profile </span>
                    <span class="selected"></span>
                </a>
            </li>



            <li class="{{(isset($page_title) && (strpos($page_title,'Campaign')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> Campaign </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Campaign') !== false) ) ? 'block':'active'}};">

                    <li class="{{isset($page_title) && ($page_title=='Campaign Create') ? 'active' : ''}}">
                        <a href="{{url('/requester/campaign/create')}}">
                            <i class="clip-plus-circle"></i>
                            <span class="title"> Add Campaign </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    
                    <li class="{{isset($page_title) && ($page_title=='Campaign List') ? 'active' : ''}}">
                        <a href="{{url('/requester/campaign/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Campaign List</span>
                            <span class="selected"></span>
                        </a>
                    </li>


                    <li class="{{isset($page_title) && ($page_title=='Campaign Participate Countdown') ? 'active' : ''}}">
                        <a href="{{url('/campaign/participate/countdown')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Campaign Countdown</span>
                            <span class="selected"></span>
                        </a>
                    </li>


                </ul>
            </li>
            

            <li class="{{(isset($page_title) && (strpos($page_title,'Question')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> Question </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Question') !== false) ) ? 'block':'active'}};">
                    <li class="{{isset($page_title) && ($page_title=='Add Question') ? 'active' : ''}}">
                        <a href="{{url('/requester/question/create')}}">
                            <i class="clip-plus-circle"></i>
                            <span class="title"> Add Question </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='All Question Content List') ? 'active' : ''}}">
                        <a href="{{url('/requester/question/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Question List</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>

            
            <li class="{{(isset($page_title) && (strpos($page_title,'Payment')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> Payment </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Payment') !== false) ) ? 'block':'active'}};">


                    <li class="{{isset($page_title) && ($page_title=='Payment') ? 'active' : ''}}">
                        <a href="{{url('/requester/payment/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Requester Payment History</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                </ul>
            </li>


        @elseif(\Auth::user()->user_role == "surveyer")

            <li class="{{isset($page_title) && ($page_title=='Dashboard') ? 'active' : ''}} ">
                <a href="{{url('dashboard')}}"><i class="clip-home-3"></i>
                    <span class="title"> Dashboard </span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="{{isset($page_title) && ($page_title=='Profile') ? 'active' : ''}} ">
                <a href="{{url('surveyer/profile')}}"><i class="clip-user-2"></i>
                    <span class="title"> My Profile </span>
                    <span class="selected"></span>
                </a>
            </li>


            <li class="{{(isset($page_title) && (strpos($page_title,'Campaign')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> Campaign </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Campaign') !== false) ) ? 'block':'active'}};">

                    <li class="{{isset($page_title) && ($page_title=='Active Campaign List') ? 'active' : ''}}">
                        <a href="{{url('/surveyer/participate/campaign/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Active Campaign List</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                    <li class="{{isset($page_title) && ($page_title=='Campaign Question Answer List') ? 'active' : ''}}">
                        <a href="{{url('/surveyer/question/answer/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Question Answer List</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                    
                    <li class="{{isset($page_title) && ($page_title=='Surveyer Participate Countdown') ? 'active' : ''}}">
                        <a href="{{url('/surveyer/participate/countdown')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Surveyer Participate Countdown</span>
                            <span class="selected"></span>
                        </a>
                    </li>


                </ul>
            </li>


            <li class="{{(isset($page_title) && (strpos($page_title,'Payment')!== false )) ? 'active' : ''}}">
                <a href="javascript:void (0)">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span class="title"> Payment </span><i class="icon-arrow"></i>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: {{( isset($page_title) && (strpos($page_title,'Payment') !== false) ) ? 'block':'active'}};">


                    <li class="{{isset($page_title) && ($page_title=='Payment') ? 'active' : ''}}">
                        <a href="{{url('/surveyer/payment/list')}}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="title">Surveyer Payment History</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                </ul>
            </li>



        @else
            <li class="active">
                <a href="{{url('dashboard')}}">
                    <i class="clip-home-3"></i>
                </a>
            </li>
        @endif
    </ul>
    <!-- end: MAIN NAVIGATION MENU -->
</div>