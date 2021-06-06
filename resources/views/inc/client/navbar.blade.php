{{-- admin navbar start --}}
<header class="main-header">
    <!-- Logo -->
    <a href="/" target="_blank" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>a</b>EAS</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Auto-</b>Emergency</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-shopping-cart"></i> Cart
                        <span class="label label-warning num_of_items_in_cart"></span>
                    </a>
                    <ul class="dropdown-menu" id="hold">
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('storage/userImages/' . Auth::guard('web')->user()->image) }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">
                            {{ Auth::guard('web')->user()->fname . ' ' . Auth::guard('web')->user()->lname }}
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset('storage/userImages/' . Auth::guard('web')->user()->image) }}" class="img-circle" alt="User Image">

                            <p>
                                {{ Auth::guard('web')->user()->fname . ' ' . Auth::guard('web')->user()->lname }}
                                <small>{{ Auth::guard('web')->user()->email }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('users.logout') }}" class="btn btn-default btn-flat">Log out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>
</header>
{{-- admin navbar end --}}
