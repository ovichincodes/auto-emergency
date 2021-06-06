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
                    <li class="active">Create New</li>
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
                    <div class="col-lg-8">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Please Fill out the following details</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label>Name</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                            <input type="text" name="name" class="form-control" placeholder="Name of the Product">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                            <input type="number" name="p_qty" class="form-control" placeholder="Quantity">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">&#8358</span>
                                            <input type="text" name="p_price" class="form-control" placeholder="Price">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="p_category" required="true">
                                            <option value="">Choose...</option>
                                            @foreach ($categories as $item)
                                                <option value={{ $item->id }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="p_desc" rows="3" placeholder="About this Product"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="productImage">Choose Product Image</label>
                                        <input type="file" name="p_image" id="productImage" class="form-control" accept="image/*">
                                        {{-- display the chosen image --}}
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <img class="img-responsive p-0 mb-2" src="" id="preview" />
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
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Create Categories</h3>
                            </div>
                            <div class="box-body">
                                <form method="POST" action="{{ route('admin.category.create') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Name</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                            <input type="text" name="name" class="form-control" placeholder="Category" required>
                                        </div>
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