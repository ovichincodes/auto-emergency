{{-- admin sidebar start --}}
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('storage/userImages/' . Auth::guard('web')->user()->image) }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::guard('web')->user()->fname . ' ' . Auth::guard('web')->user()->lname }}</p>
                <small><i class="fa fa-circle text-success"></i> Online</small>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active menu-open">
                <a href="{{ route('users.dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('users.services') }}">
                    <i class="fa fa-tasks"></i>
                    <span>Services</span>
                </a>
            </li>
            <li class="treeview">
                <a href="javascript:void(0)">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Shopping</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('shopping.products') }}">
                            <i class="fa fa-circle-o"></i> Products
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shopping.cart') }}">
                            <i class="fa fa-circle-o"></i> <span>Cart</span>
                            <span class="pull-right-container">
                                <small class="label pull-right bg-yellow num_of_items_in_cart"></small>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shopping.orders') }}">
                            <i class="fa fa-circle-o"></i> <span>Orders</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('users.profile') }}">
                    <i class="fa fa-user"></i> <span>Profile</span>
                </a>
            </li>
            <li>
                <a href="{{ route('users.logout') }}">
                    <i class="fa fa-sign-out"></i> <span>Log Out</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
{{-- admin sidebar end --}}
