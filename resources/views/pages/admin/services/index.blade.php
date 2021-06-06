@extends('layouts.app')

@section('content')
    <div class="wrapper">

        @include('inc.admin.navbar')
        @include('inc.admin.sidebar', ['totalUsers' => count($users), 'active_navlink' => 'services'])

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
                    <li class="active">Available Services</li>
                </ol>
            </section>

            <section class="content" style="margin-top: 2rem;">
                {{-- include the messages file --}}
                <div class="row">
                    <div class="col-sm-12">
                        @include('messages')
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        @if (count($services) > 0)
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">All Services</h3>
                                    <a href="{{ route('admin.services.create') }}" class="btn btn-default" style="float: right !important;">Create New</a>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name of Owner</th>
                                                <th>Category</th>
                                                <th>Address</th>
                                                <th>Date Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cnt = 0;
                                            @endphp
                                            @foreach ($services as $service)
                                                @php
                                                    $cnt++;
                                                @endphp
                                                <tr>
                                                    <td>{{ $cnt }}</td>
                                                    <td>{{ $service->name }}</td>
                                                    <td>
                                                        @switch($service->category)
                                                            @case(1)
                                                                <div class="label label-danger">
                                                                    Fuel Station
                                                                </div>
                                                                @break
                                                            @case(2)
                                                                <div class="label label-success">
                                                                    Hospital
                                                                </div>
                                                                @break
                                                            @case(3)
                                                                <div class="label label-warning">
                                                                    Mechanic
                                                                </div>
                                                                @break
                                                            @case(4)
                                                                <div class="label label-primary">
                                                                    Police Station
                                                                </div>
                                                                @break
                                                            @default
                                                                <div class="label label-info">
                                                                    Towing Van
                                                                </div>
                                                                @break
                                                            @endswitch
                                                    </td>
                                                    <td>{{ $service->address }}</td>
                                                    <td>{{ $service->created_at->isoFormat("MMMM Do, YYYY") }}</td>
                                                    <td>
                                                        <span class="text-info view-services" data-toggle="modal" data-target="#map-modal" data-toggle="tooltip" data-placement="top" title="View in Map" style="text-decoration: none;" v-id={{ $service->id }}>
                                                            <button><i class="fa fa-eye"></i></button>
                                                        </span>
                                                        <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit Service" href="{{ route('admin.services.edit', $service->id) }}" style="text-decoration:none;">
                                                            <button><i class="fa fa-pencil"></i></button>
                                                        </a>
                                                        <span class="text-danger delete-services" data-toggle="tooltip" data-placement="top" title="Delete Service" style="cursor: pointer;" d-id={{ $service->id }}>
                                                            <button><i class="fa fa-trash"></i></button>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <p class="text-danger">No Services Available!</p>
                            <a href="{{ route('admin.services.create') }}" class="btn btn-default">Create New</a>
                        @endif
                    </div>
                </div>
            </section>
        </div>

        @include('inc.admin.footer')
    </div>

    {{-- modal for showing the addresses on the maps --}}
    <div class="modal fade" id="map-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Viewing <span id="address_name" class="text-bold"></span> Address on Map</h4>
                </div>
                <div class="modal-body">
                    <div style="height: 500px; width: 100%;" id="map"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
