<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{URL::asset('')}}images/users/{{Session::get('avatar')}}" alt="">{{Session::get('username')}}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="{{URL::asset('')}}admin/user/profile-{{Session::get('user_id')}}"> Profile</a></li>
                        <li><a href="{{URL::asset('')}}admin/log-out"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>

                
            </ul>
        </nav>
    </div>
</div>