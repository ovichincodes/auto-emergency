@extends('layouts.app')

@section('content')
    <div class="wrapper">

        @include('inc.client.navbar')
        @include('inc.client.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <h1>Product Details</h1>
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
                    <li class="active">{{ $item->name }}</li>
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
                    <div class="col-md-9">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <img class="img-responsive img-rounded" src="{{ asset('storage/productImages/' . $item->image) }}" alt="">
                                        <hr style="border-top: 1px solid #ccc;">
                                        <p class="text-bold">SHARE THIS PRODUCT</p>
                                        <span style="font-size: 20px; margin-right: 10px;"><i class="fa fa-facebook"></i></span>
                                        <span style="font-size: 20px; margin-right: 10px;"><i class="fa fa-twitter"></i></span>
                                        <span style="font-size: 20px; margin-right: 10px;"><i class="fa fa-instagram"></i></span>
                                        <span style="font-size: 20px; margin-right: 10px;"><i class="fa fa-youtube"></i></span>
                                        <span style="font-size: 20px; margin-right: 10px;"><i class="fa fa-whatsapp"></i></span>
                                        <span style="font-size: 20px; margin-right: 10px;"><i class="fa fa-linkedin"></i></span>
                                        <span style="font-size: 20px; margin-right: 10px;"><i class="fa fa-telegram"></i></span>
                                    </div>
                                    <div class="col-sm-8">
                                        <a href="{{ route('shopping.products.categories', $item->category->slug) }}" class="label label-danger" style="font-size: 100%;">
                                            {{ $item->category->name }}
                                        </a>
                                        <h3>{{ $item->name }}</h3>
                                        <h3 class="text-bold"><span>&#8358</span> {{ $item->price }}</h3>
                                        @if ($item->quantity === 0)
                                            <p class="text-danger">ITEM OUT OF STOCK</p>
                                        @else
                                            <div id="cartBtnSection"></div>
                                            <script type="text/javascript">
                                                const items = JSON.parse(localStorage.getItem('items'));
                                                // add to cart button
                                                let add_to_cart_btn = `
                                                    <button id="add-to-cart" class="btn btn-primary" product-id="{{ $item->id }}" style="font-size: 18px;">
                                                        <i class="fa fa-cart-plus"></i>
                                                        Add to Cart
                                                    </button>
                                                `;
                                                // increase and decrease the quantity of this product in the cart
                                                let increase_and_decrease_btns = `
                                                    <div>
                                                        <button class="btn btn-warning btn-decr-qty" product-id="{{ $item->id }}" style="font-size: 16px;">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        <span class="num_this_item" style="margin: 0 15px; font-size: 16px;">3</span>
                                                        <button class="btn btn-success btn-incr-qty" product-id="{{ $item->id }}" style="font-size: 16px;">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                        <span style="margin: 0 15px; font-size: 16px;">
                                                            (<span  class="num_this_item">3</span> of this item added)
                                                        </span>
                                                    </div>
                                                `;
                                                if (items !== null) {
                                                    const thisItem = items.filter(item => item.id === {!! $item->id !!});
                                                    // console.log(thisItem);
                                                    if (thisItem.length === 0) {
                                                        document.getElementById('cartBtnSection').innerHTML = add_to_cart_btn;
                                                    } else {
                                                        document.getElementById('cartBtnSection').innerHTML = increase_and_decrease_btns;
                                                        let num_of_this_item = document.getElementsByClassName('num_this_item');
                                                        for (i = 0; i < num_of_this_item.length; i++) {
                                                            num_of_this_item[i].innerHTML = thisItem[0].reqQty;
                                                        }
                                                    }
                                                } else {
                                                    document.getElementById('cartBtnSection').innerHTML = add_to_cart_btn;
                                                }
                                            </script>                                        
                                        @endif

                                        <hr style="border-top: 1px solid #ccc;">
                                        <p class="text-bold">ABOUT THIS PRODUCT</p>
                                        <p class="text-justify">{{ $item->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Delivery information section --}}
                    <div class="col-md-3">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title text-bold">Delivery and Returns</h3>
                            </div>
                            <div class="box-body">
                                <div style="margin-top: -10px;">
                                    <h5 class="text-bold">
                                        <i class="fa fa-send"></i>
                                        Shipping
                                    </h5>
                                    <p class="text-justify">
                                        Our free shipping services apply to only customers in Anambra State.
                                    </p>
                                </div>
                                <div style="margin-top: 20px;">
                                    <h5 class="text-bold">
                                        <i class="fa fa-truck"></i>
                                        Delivery Information
                                    </h5>
                                    <p class="text-justify">
                                        Normally delivered within 5 working days, delivery is nationwide.
                                    </p>
                                </div>
                                <div style="margin-top: 20px;">
                                    <h5 class="text-bold">
                                        <i class="fa fa-undo"></i>
                                        Return Policy
                                    </h5>
                                    <p class="text-justify">
                                        15% will be taken off your pay when you return after 15days!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- category and other products --}}
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-9 col-md-push-3">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title text-bold">Other Products in this Category</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                @if (count($related_products) > 1)
                                    <div class="row">
                                        @foreach ($related_products as $r_item)
                                            @if ($r_item->slug != $item->slug)
                                                <a href="{{ route('shopping.products.single', $r_item->slug) }}" class="text-black">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="box box-widget widget-user">
                                                            <div class="widget-user-header bg-black" style="background: url('{{ asset('storage/productImages/' . $r_item->image) }}') center center;"></div>
                                                            <div class="box-footer">
                                                                <div class="row">
                                                                    <div class="col-sm-12 border-right">
                                                                        <div class="description-block">
                                                                            <h3 class="description-header">{{ $r_item->name }}</h3>
                                                                            <span class="description-text">
                                                                                <div class="label label-danger">
                                                                                    {{ $r_item->category->name }}
                                                                                </div>
                                                                            </span>
                                                                            <h3 class="description-header"><span>&#8358</span> {{ $r_item->price }}</h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif
                                        @endforeach
                                        <div class="col-sm-12">
                                            <p class="text-center">
                                                <a class="btn btn-default" href="{{ route('shopping.products.categories', $item->category->slug) }}">View All</a>
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-danger">No Other Products in this Category!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-pull-9">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title text-bold">Categories</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <ul class="products-list product-list-in-box">
                                    @if (count($categories) > 0)
                                        @foreach ($categories as $item)
                                            <li class="item">
                                                <a href="{{ route('shopping.products.categories', $item->slug) }}">
                                                    <div>
                                                        <span class="product-title">
                                                            {{ $item->name }}
                                                            <span class="label label-warning pull-right">{{ count($item->products) }}</span>
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        <p class="text-danger">No Categories Available!</p>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @include('inc.client.footer')
    </div>
@endsection
