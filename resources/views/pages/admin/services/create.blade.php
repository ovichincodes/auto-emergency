@extends('layouts.app')


@section('content')
    <div class="wrapper">

        @include('inc.admin.navbar')
        @include('inc.admin.sidebar', ['totalUsers' => count($users), 'active_navlink' => 'create-services'])

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
                <h1>{{ $title }}</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="fa fa-dashboard"></i> Manage Services
                        </a>
                    </li>
                    <li class="active">Create</li>
                </ol>
            </section>

            {{-- main content --}}
            <section class="content">
                {{-- include the messages file --}}
                <div class="row">
                    <div class="col-sm-12">
                        @include('messages')
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Please Fill out the following details</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <form method="POST" action="{{ route('admin.services.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Name</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-edit"></i>
                                            </span>
                                            <input type="text" name="name" class="form-control" placeholder="Owner of Service">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Location</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-map-marker"></i>
                                            </span>
                                            <input type="text" name="main_location" id="search_address" class="form-control" placeholder="Enter Location">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Category of Service</label>
                                        <select class="form-control" name="category" required="true">
                                            <option value="">Choose...</option>
                                            <option value="1">Fuel Station</option>
                                            <option value="2">Hospital</option>
                                            <option value="3">Mechanic</option>
                                            <option value="4">Police Station</option>
                                            <option value="5">Towing Van</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="desc" rows="3" placeholder="About this Service"></textarea>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('inc.admin.footer')
    </div>
@endsection