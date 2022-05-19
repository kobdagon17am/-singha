<nav class="navbar header-navbar  pcoded-header" >
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu" id="mobile-collapse" href="#!"><i class="ti-menu"></i></a>
            <div class="mobile-search">
                <div class="header-search">
                    <div class="main-search morphsearch-search">
                        <div class="input-group">
                            <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                            <input type="text" class="form-control" placeholder="Enter Keyword">
                            <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#"><img src="{{URL::asset('public/assets/img/logo.png')}}" width="160px" alt="Theme-Logo"></a>
            <a class="mobile-options"><i class="ti-more"></i></a>
        </div>

        <div class="navbar-container container-fluid">
            <ul class="nav-right">
                <li class="user-profile header-notification">
                    <a href="#!">
                        <img src="{{URL::asset('public/assets/bootstrap4/assets/images/avatar-4.jpg')}}" class="img-radius" alt="User-Profile-Image">
                        {{ Auth::user()->name }}
                        <i class="ti-angle-down"></i>
                    </a>
                    <ul class="show-notification profile-notification">
                        <li>
                        <a href="{{ route('backend.admin.logout') }}"><i class="fa fa-sign-out"></i> ออกจากระบบ </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
