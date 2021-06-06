@extends('layouts.app')

@section('content')
    <div class="wrapper">

        @include('inc.admin.navbar')
        @include('inc.admin.sidebar', ['totalUsers' => count($users), 'active_navlink' => 'create-products'])

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
                            <i class="fa fa-dashboard"></i> Manage Products
                        </a>
                    </li>
                    <li class="active">Available Products</li>
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
                        @if (count($products) > 0)
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">All Products</h3>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-default" style="float: right !important;">Create New</a>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Quantity Left</th>
                                                <th>Date Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cnt = 0;
                                            @endphp
                                            @foreach ($products as $prd)
                                                @php
                                                    $cnt++;
                                                @endphp
                                                <tr>
                                                    <td>{{ $cnt }}</td>
                                                    <td>
                                                        <img src="{{ asset('storage/productImages/' . $prd->image) }}" class="img-responsive img-rounded" style="height: 50px; width: 75px;" alt="Product Image">
                                                    </td>
                                                    <td>{{ $prd->name }}</td>
                                                    <td>
                                                        <div class="label label-danger">
                                                            {{ $prd->category->name }}
                                                        </div>
                                                    </td>
                                                    <td><span>&#8358</span>{{ $prd->price }}</td>
                                                    <td>{{ $prd->quantity }}</td>
                                                    <td>{{ $prd->created_at->isoFormat("MMMM Do, YYYY") }}</td>
                                                    <td>
                                                        <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit Product" href="{{ route('admin.products.edit', $prd->slug) }}" style="text-decoration:none;">
                                                            <button><i class="fa fa-pencil"></i></button>
                                                        </a>
                                                        <span class="text-danger delete-prds" data-toggle="tooltip" data-placement="top" title="Delete Product" style="cursor: pointer;" d-id={{ $prd->id }}>
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
                            <p class="text-danger">No Products Available!</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>

        @include('inc.admin.footer')
    </div>
@endsection
