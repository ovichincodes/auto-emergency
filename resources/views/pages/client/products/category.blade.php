@extends('layouts.app')

@section('content')
    <div class="wrapper">

        @include('inc.client.navbar')
        @include('inc.client.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <h1>{{ $title }}</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route('users.dashboard') }}">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="fa fa-dashboard"></i> Shopping
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shopping.products') }}">
                            <i class="fa fa-dashboard"></i> Products
                        </a>
                    </li>
                    <li class="active">{{ $title }}</li>
                </ol>
            </section>

            <section class="content" style="margin-top: 2rem;">
                <div class="row">
                    <div class="col-xs-12">
                        <label for="category">Category:</label>
                        <select name="" id="category">
                            <option value="0">All</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @if (count($products) > 0)
                            <div class="row" style="margin-top: 10px;">
                                @foreach ($products as $item)
                                    <a href="{{ route('shopping.products.single', $item->slug) }}" class="text-black">
                                        <div class="col-lg-3 col-sm-4">
                                            <div class="box box-widget widget-user">
                                                <div class="widget-user-header bg-black" style="background: url('{{ asset('storage/productImages/' . $item->image) }}') center center;"></div>
                                                <div class="box-footer">
                                                    <div class="row">
                                                        <div class="col-sm-12 border-right">
                                                            <div class="description-block">
                                                                <h3 class="description-header">{{ $item->name }}</h3>
                                                                <span class="description-text">
                                                                    <div class="label label-danger">
                                                                        {{ $item->category->name }}
                                                                    </div>
                                                                </span>
                                                                <h3 class="description-header"><span>&#8358</span> {{ $item->price }}</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-danger">No Products in this Category!</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>

        @include('inc.client.footer')
    </div>
@endsection
