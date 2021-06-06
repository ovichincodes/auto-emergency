@extends('layouts.app')

@section('content')
    <div class="wrapper">
        @include('inc.client.navbar')
        @include('inc.client.sidebar')
        
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    {{ $title }}
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route('users.dashboard') }}">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </a>
                    </li>
                    <li class="active">
                        <i class="fa fa-user"></i> Profile
                    </li>
                </ol>
            </section>
        
            <!-- Main content -->
            <section class="content">
                {{-- include the messages file --}}
                <div class="row">
                    <div class="col-sm-12">
                        @include('messages')
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <img class="profile-user-img img-responsive img-circle"
                                src="{{ asset('storage/userImages/' . Auth::user()->image) }}" alt="User profile picture">
                                <h3 class="profile-username text-center">
                                    {{ Auth::user()->fname . ' ' . Auth::user()->lname }}
                                </h3>
                                <p class="text-muted text-center">
                                    {{ Auth::user()->email }}
                                </p>
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item text-center">
                                        <strong>
                                            <i class="fa fa-map-marker margin-r-5"></i> 
                                            My Current Location
                                        </strong>
                                        <p class="text-muted">Malibu, California</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Update Password</h3>
                            </div>
                            <div class="box-body">
                                <form method="POST" action="{{ route('users.password.update') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                            <input type="password" name="password" class="form-control" placeholder="New Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i>
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#settings" data-toggle="tab">Update Profile</a></li>
                            </ul>
                            <div class="tab-content">
                                {{-- update user profile --}}
                                <div class="active tab-pane" id="settings">
                                    <form class="form-horizontal" method="POST" action="{{ route('users.profile.update') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">First Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="fname" class="form-control" placeholder="First Name" value="{{ Auth::user()->fname }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Last Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="lname" class="form-control" placeholder="Last Name" value="{{ Auth::user()->lname }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" class="form-control""
                                                placeholder="Email Address" value="{{ Auth::user()->email }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Mobile</label>
                                            <div class="col-sm-10">
                                                <input type="tel" name="phone" class="form-control" placeholder="Phone Number" value="{{ Auth::user()->phone }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="address" class="form-control" id="search_address" placeholder="Home Address or Address of a Close Area" value="{{ Auth::user()->address }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-save"></i>
                                                    Update
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('inc.client.footer')
    </div>
@endsection
