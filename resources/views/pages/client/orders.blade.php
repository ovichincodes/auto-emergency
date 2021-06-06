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
                    <li class="active">Orders</li>
                </ol>
            </section>

            <section class="content" style="margin-top: 2rem;">
                <div class="row">
                    <div class="col-xs-12">
                        @if (count($orders) > 0)
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Your Orders</h3>
                                    <a href="{{ route('shopping.products') }}" class="btn btn-default" style="float: right !important;">Order Now!</a>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Items Count</th>
                                                    <th>Price</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $cnt = 0;
                                                @endphp
                                                @foreach ($orders as $ord)
                                                    @php
                                                        $cnt++;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $cnt }}</td>
                                                        <td>{{ $ord->created_at->isoFormat("MMMM Do, YYYY") }}</td>
                                                        <td id="items-count{{$cnt}}"></td>
                                                        <td id="items-price{{$cnt}}"><span>&#8358</span></td>
                                                        <td>
                                                            @switch($ord->status)
                                                                @case(0)
                                                                    <span class="label label-danger">Pending</span>
                                                                    @break
                                                                @case(1)
                                                                    <span class="label label-warning">Processing</span>
                                                                    @break
                                                                @default
                                                                    <span class="label label-success">Delivered</span>
                                                            @endswitch
                                                        </td>
                                                        <td>
                                                            <span class="text-success" onclick="showOrder(this)" data-toggle="tooltip" data-placement="top" title="View Order" style="cursor: pointer;" o-id={{ $ord->id }}>
                                                                <button data-toggle="modal" data-target="#view-items-modal"><i class="fa fa-eye"></i></button>
                                                            </span>
                                                            <span class="text-danger delete-order" data-toggle="tooltip" data-placement="top" title="Delete Order" style="cursor: pointer;" o-id={{ $ord->id }}>
                                                                <button><i class="fa fa-trash"></i></button>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <script>
                                                        items = JSON.parse('{!! $ord->items !!}');
                                                        subTotal = 0;
                                                        items.forEach((item) => {
                                                            subTotal += parseInt(item.reqQty) * parseInt(item.price);
                                                        });
                                                        document.getElementById('items-count{!! $cnt !!}').innerText = items.length
                                                        document.getElementById('items-price{!! $cnt !!}').innerText += ` ${subTotal + 1000}.00`
                                                    </script>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-danger">You have not ordered anything yet!</p>
                            <a href="{{ route('shopping.products') }}" class="btn btn-default">Order Now!</a>
                        @endif
                    </div>
                </div>
            </section>
        </div>

        {{-- view order items modal --}}
        <div class="modal fade" id="view-items-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Order Items</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="order-items">
                                        <script>
                                            // all the records in the orders table
                                            let orderItemsArray = <?php echo json_encode($orders); ?>;
                                            // order is the view element with the o-id attribute and the id attribute is the id of the order
                                            function showOrder(order) {
                                                let singleorderitem = orderItemsArray.filter(ord => parseInt(ord.id) === parseInt(order.getAttribute('o-id')));
                                                // items of a single order record
                                                let itemsofsingleorder = JSON.parse(singleorderitem[0].items);
                                                let orderitems, subTotal1 = 0;
                                                itemsofsingleorder.forEach((item, index) => {
                                                    subTotal1 += parseInt(item.reqQty) * parseInt(item.price);
                                                    orderitems += `
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
                                                                <span>&#8358</span> ${item.reqQty * item.price}.00
                                                            </td>
                                                        </tr>
                                                    `;
                                                });
                                                orderitems += `
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>Delivery Fee:</td>
                                                        <td><span>&#8358</span> 1000.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>Grand Total:</td>
                                                        <td><span>&#8358</span> ${subTotal1 + 1000}.00</td>
                                                    </tr>
                                                `;
                                                document.getElementById("order-items").innerHTML = orderitems;
                                            }
                                        </script>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @include('inc.client.footer')
    </div>
@endsection
