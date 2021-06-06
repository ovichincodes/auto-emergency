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
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    
                </div>
            </section>
        </div>

        @include('inc.client.footer')

    </div>

@endsection
