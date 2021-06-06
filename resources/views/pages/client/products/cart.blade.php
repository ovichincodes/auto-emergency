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
                            <i class="fa fa-shopping-cart"></i> Shopping
                        </a>
                    </li>
                    <li class="active">Cart</li>
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
                    <div class="col-md-10 col-md-offset-1">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title text-bold">CART SUMMARY</h3>
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
                                <h4 id="cart-empty" class="text-center text-danger text-bold" style="display: none;">
                                    <img style="display: block;
                                    margin-left: auto;
                                    margin-right: auto;" src="{{ asset('images/client/empty-cart.png') }}" alt="Empty Cart">
                                    Your cart is empty!
                                </h4>
                                <div class="table-responsive" id="cart-full">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Item</th>
                                                <th>QTY</th>
                                                <th>Unit Price</th>
                                                <th>Sub Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cart-body"></tbody>
                                    </table>
                                </div>
                                <div style="float: right; margin: 20px; 0">
                                    <p class="text-center">
                                        <a href="{{ route('shopping.products') }}" id="btnContinueShopping" class="btn btn-default">
                                            <i class="fa fa-shopping-cart"></i>
                                            CONTINUE SHOPPING
                                        </a>
                                    </p>
                                    <a href="{{ route('shopping.checkout') }}" id="btnProceedCheckout" class="btn btn-primary">
                                        <i class="fa fa-money"></i>
                                        PROCEED TO CHECKOUT
                                    </a>
                                </div>
                                <script type="text/javascript">
                                    let storedItems = JSON.parse(localStorage.getItem("items"));
                                    if (storedItems.length > 0 && storedItems !== null) {
                                        let items = ``;
                                        let totalPrice = 0;
                                        storedItems.forEach((item, index) => {
                                            totalPrice += parseInt(item.price) * item.reqQty;
                                            items += `
                                                <tr>
                                                    <td>${index + 1}</td>
                                                    <td>
                                                        <a href="${location.origin}/shopping/products/${item.slug}" class="text-black" target="_blank">
                                                            <img class="img-responsive img-rounded" style="height: 40px; width: 50px; display: initial;" src="${
                                                                location.origin
                                                            }/storage/productImages/${
                                                                item.image
                                                            }" alt="Product Image">
                                                            <span>${item.name}</span>
                                                        </a>
                                                    </td>
                                                    <td>${item.reqQty}</td>
                                                    <td>
                                                        <span>&#8358</span> ${item.price}
                                                    </td>
                                                    <td>
                                                        <span>&#8358</span> ${item.reqQty * item.price}
                                                    </td>
                                                    <td>
                                                        <button user-id="{{ Auth::id() }}" class="btn btn-xs btn-warning btn-decr-qty" product-id="${
                                                            item.id
                                                        }">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        <button user-id="{{ Auth::id() }}" class="btn btn-xs btn-success btn-incr-qty" product-id="${
                                                            item.id
                                                        }">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                        <button user-id="{{ Auth::id() }}" class="btn btn-xs btn-danger btn-remove-item" product-id="${
                                                            item.id
                                                        }">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            `;
                                        });
                                        items += `
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Grand Total:</td>
                                                <td><span>&#8358</span> ${totalPrice}</td>
                                                <td></td>
                                            </tr>
                                        `;
                                        document.getElementById("cart-body").innerHTML = items;
                                    } else {
                                        document.getElementById("cart-full").style.display = 'none';
                                        document.getElementById("cart-empty").style.display = 'block';
                                        document.getElementById("btnProceedCheckout").style.display = 'none';
                                        document.getElementById("btnContinueShopping").innerText = 'Start Shopping';
                                        document.getElementById("btnContinueShopping").parentElement.parentElement.style.cssFloat = 'none';
                                    }
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
