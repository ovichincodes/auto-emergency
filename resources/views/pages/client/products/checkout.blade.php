@extends('layouts.app')

@section('content')
    <script>
        if (
            localStorage.getItem("items") === null ||
            JSON.parse(localStorage.getItem("items")).length === 0
        ) {
            window.location.replace("/shopping/cart");
        }
    </script>
    <div class="wrapper">

        @include('inc.client.navbar')
        @include('inc.client.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <h1 class="text-bold">{{ $title }} Details</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route('users.dashboard') }}">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="fa fa-shopping-cart"></i> Shopping
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shopping.cart') }}">
                            <i class="fa fa-shopping-cart"></i> Cart
                        </a>
                    </li>
                    <li class="active">Checkout</li>
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
                    <div class="col-md-8">
                        <span class="text-bold">CHECKOUT</span>
                        {{-- delivery address information --}}
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title text-bold">
                                    <i class="fa fa-check-circle" style="color: #a3cf62;" aria-hidden="true"></i>
                                    <span style="margin-left: 10px;">1. ADDRESS DETAILS</span>
                                </h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div style="margin-left: 30px;">
                                    <p class="text-bold">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <span style="margin-left: 8px;">
                                            {{ Auth::user()->fname . ' ' . Auth::user()->lname }}
                                        </span>
                                    </p>
                                    <p>
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        <span style="margin-left: 8px;" id="txtNewChangedAddress">
                                            {{ Auth::user()->address }}
                                        </span>
                                    </p>
                                    <p>
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        <span style="margin-left: 8px;">
                                            {{ Auth::user()->phone }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- delivery method --}}
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title text-bold">
                                    <i class="fa fa-check-circle" style="color: #a3cf62;" aria-hidden="true"></i>
                                    <span style="margin-left: 10px;">2. DELIVERY METHOD</span>
                                </h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div style="margin-left: 30px;">
                                    <div class="form-group">
                                        <span>Door Delivery</span>
                                        <br>
                                        <label>Delivery between 3 - 5 working days for 
                                            <span class="text-bold" style="color: #f39c12">
                                                <span>&#8358</span>1000
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- payment method --}}
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title text-bold">
                                    <i class="fa fa-check-circle" style="color: #a3cf62;" aria-hidden="true"></i>
                                    <span style="margin-left: 10px;">3. PAYMENT METHOD</span>
                                </h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div style="margin-left: 30px;">
                                    <div class="form-group" style="margin-top: 5px;">
                                        <span class="text-bold">Payment will be made on Delivery</span>
                                        <hr style="border-top: 1px solid #ececec;">
                                        <div id="itemsToBePaid"></div>
                                        <script>
                                            let storedItems = JSON.parse(localStorage.getItem("items"));
                                            let subTotal = 0;
                                            storedItems.forEach((item) => {
                                                subTotal += parseInt(item.reqQty) * parseInt(item.price);
                                            });
                                            let html = `
                                                <section>
                                                    <p>
                                                        Subtotal
                                                        <span class="pull-right text-bold"><span>&#8358</span>${subTotal}.00</span>
                                                    </p>
                                                    <p>
                                                        Delivery/Shipping Fee
                                                        <span class="pull-right text-bold"><span>&#8358</span>1000.00</span>
                                                    </p>
                                                    <hr style="border-top: 1px solid #ececec;">
                                                    <p class="text-bold">
                                                        Total
                                                        <span class="pull-right" style="color: #f39c12;"><span>&#8358</span>${subTotal + 1000}.00</span>
                                                    </p>
                                                </section>
                                            `;
                                            document.getElementById('itemsToBePaid').innerHTML = html;
                                        </script>
                                        <p class="text-center">
                                            <button class="btn btn-warning" id="btnConfirmOrder" style="width: 100%;">CONFIRM ORDER</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- order summary --}}
                    <div class="col-md-4">
                        <span class="text-bold">ORDER SUMMARY</span>
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title text-bold">YOUR ORDER <span id="cartNoItems"></span></h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div id="cart-items"></div>
                                <script>
                                    let storedItems1 = JSON.parse(localStorage.getItem("items"));
                                    document.getElementById('cartNoItems').innerText = `(${storedItems1.length} item(s))`;
                                    let items1 = ``;
                                    let subTotal1 = 0;
                                    storedItems1.forEach((item) => {
                                        subTotal1 += parseInt(item.reqQty) * parseInt(item.price);
                                        items1 += `
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <img class="img-responsive img-rounded" style="height: 40px; width: 50px; display: initial;" src="${location.origin}/storage/productImages/${item.image}" alt="Product Image">
                                                    <span>${item.name}</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="pull-right" style="color: #f39c12;"><span>&#8358</span>${item.price}</span>
                                                    <br>
                                                    <span class="pull-right" >Qty: ${item.reqQty}</span>
                                                </div>
                                            </div>
                                            <hr style="border-top: 1px solid #ececec;">
                                        `;
                                    });
                                    let html1 = `
                                        <section>
                                            <p>
                                                Subtotal
                                                <span class="pull-right text-bold"><span>&#8358</span>${subTotal1}.00</span>
                                            </p>
                                            <p>
                                                Delivery/Shipping Fee
                                                <span class="pull-right text-bold"><span>&#8358</span>1000.00</span>
                                            </p>
                                            <hr style="border-top: 1px solid #ececec;">
                                            <p class="text-bold">
                                                Total
                                                <span class="pull-right" style="color: #f39c12;"><span>&#8358</span>${subTotal1 + 1000}.00</span>
                                            </p>
                                            <hr style="border-top: 1px solid #ececec;">
                                            <h4 class="text-center text-bold">
                                                <a href="${location.origin}/shopping/cart" style="color: #f39c12;" target="_blank">MODIFY CART</a>
                                            </h4>
                                        </section>
                                    `;
                                    document.getElementById('cart-items').innerHTML = items1 + html1;
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @include('inc.client.footer')
    </div>
@endsection
