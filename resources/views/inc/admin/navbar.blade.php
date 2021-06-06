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
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('storage/adminImage/' . Auth::guard('admin')->user()->image) }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">
                            {{ Auth::guard('admin')->user()->fname . ' ' . Auth::guard('admin')->user()->lname }}
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset('storage/adminImage/' . Auth::guard('admin')->user()->image) }}" class="img-circle" alt="Admin Image">

                            <p>
                                {{ Auth::guard('admin')->user()->fname . ' ' . Auth::guard('admin')->user()->lname }}
                                <small>Administrator.</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">Log out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>
</header>
{{-- admin navbar end --}}
