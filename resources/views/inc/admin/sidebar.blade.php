{{-- admin sidebar start --}}
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('storage/adminImage/' . Auth::guard('admin')->user()->image) }}" class="img-circle" alt="Admin Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::guard('admin')->user()->fname . ' ' . Auth::guard('admin')->user()->lname }}</p>
                <small><i class="fa fa-circle text-success"></i> Online</small>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="menu-open {{ $active_navlink === 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ $active_navlink === 'users' ? 'active' : '' }}">
                <a href="{{ route('admin.users') }}">
                    <i class="fa fa-users"></i>
                    <span>Manage Users</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-green">{{ $totalUsers ?? '' }}</small>
                    </span>
                </a>
            </li>
            <li class="treeview">
                <a href="javascript:void(0)">
                    <i class="fa fa-laptop"></i>
                    <span>Manage Services</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $active_navlink === 'create-services' ? 'active' : '' }}">
                        <a href="{{ route('admin.services.create') }}">
                            <i class="fa fa-circle-o"></i> Add Services
                        </a>
                    </li>
                    <li class="{{ $active_navlink === 'services' ? 'active' : '' }}">
                        <a href="{{ route('admin.services.index') }}">
                            <i class="fa fa-circle-o"></i> Available Services
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="javascript:void(0)">
                    <i class="fa fa-laptop"></i>
                    <span>Manage Products</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $active_navlink === 'create-products' ? 'active' : '' }}">
                        <a href="{{ route('admin.products.create') }}">
                            <i class="fa fa-circle-o"></i> Create New
                        </a>
                    </li>
                    <li class="{{ $active_navlink === 'products' ? 'active' : '' }}">
                        <a href="{{ route('admin.products.index') }}">
                            <i class="fa fa-circle-o"></i> Available Products
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ $active_navlink === 'orders' ? 'active' : '' }}">
                <a href="{{ route('admin.orders') }}">
                    <i class="fa fa-shopping-cart"></i> <span>Orders</span>
                </a>
            </li>
            <li class="{{ $active_navlink === 'profile' ? 'active' : '' }}">
                <a href="{{ route('admin.profile') }}">
                    <i class="fa fa-user"></i> <span>Profile</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.logout') }}">
                    <i class="fa fa-sign-out"></i> <span>Log Out</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
{{-- admin sidebar end --}}
