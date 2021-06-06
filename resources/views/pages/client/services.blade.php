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
                        <i class="fa fa-tasks"></i> Services
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
                <div class="row" style="margin-top: 10px;">
                    <div class="col-xs-12">
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title text-bold">Available Services</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Select a Service</label>
                                    <select class="form-control select2" id="select-service" style="width: 100%;">
                                        <option value="0" selected="selected">Chose...</option>
                                        <option value="1">Fuel Station</option>
                                        <option value="2">Hospital</option>
                                        <option value="3">Mechanic</option>
                                        <option value="4">Police Station</option>
                                        <option value="5">Towing Van</option>
                                    </select>
                                </div>
                                <div id="service-div" style="display: none;" class="form-group">
                                    <label id="service-name"></label>
                                    <select class="form-control select2" id="select-service-names" style="width: 100%;">
                                        <option value="0" selected="selected">Chose...</option>
                                    </select>
                                </div>
                                <div style="height: 500px; width: 100%;" id="servicesMap"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('inc.client.footer')
    </div>
@endsection
