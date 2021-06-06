@extends('layouts.app')


@section('content')
    <div class="wrapper">

        @include('inc.admin.navbar')
        @include('inc.admin.sidebar', ['totalUsers' => count($users), 'active_navlink' => 'create-products'])

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
                            <i class="fa fa-dashboard"></i> Manage Products
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}">
                            <i class="fa fa-dashboard"></i> Available Products
                        </a>
                    </li>
                    <li class="active">Edit</li>
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
                    <div class="col-md-offset-1 col-md-10">
                        @if ($product)
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Please Fill out the following details</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label>Name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                                <input type="text" name="p_name" class="form-control" placeholder="Name of the Product" value="{{ $product->name }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                                <input type="number" name="p_qty" class="form-control" placeholder="Quantity" value="{{ $product->quantity }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Price</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">&#8358</span>
                                                <input type="text" name="p_price" class="form-control" placeholder="Price" value="{{ $product->price }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-control" name="p_category" id="cate-ID" required="true">
                                                <option value="">Choose...</option>
                                                @foreach ($categories as $item)
                                                    <option value={{ $item->id }}>{{ $item->name }}</option>
                                                @endforeach
                                                <script type="text/javascript">
                                                    var pOptions = document.getElementById('cate-ID').options;
                                                    for (i = 0; i < pOptions.length; i++) {
                                                        if (pOptions[i].value == '{{ $product->category_id }}') {
                                                            pOptions[i].selected = true;
                                                        }
                                                    }
                                                </script>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="p_desc" rows="3" placeholder="About this Product">{{ $product->description }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="productImage">Choose Product Image</label>
                                            <input type="file" name="p_image" id="productImage" class="form-control" accept="image/*">
                                            {{-- display the chosen image --}}
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <img class="img-responsive p-0 mb-2" src="{{ asset('storage/productImages/' . $product->image) }}" id="preview" />
                                                    <script>
                                                        // display the project image in the img tag
                                                        document.getElementById('productImage').addEventListener('change', (e) => {
                                                            var output = document.getElementById("preview");
                                                            output.src = URL.createObjectURL(event.target.files[0]);
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            <p class="text-danger">Product Not Found!</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>
        @include('inc.admin.footer')
    </div>
@endsection