@extends('layouts.app')

@section('content')
    <div class="wrapper">

        @include('inc.client.navbar')
        @include('inc.client.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <h1>ERROR</h1>
            </section>

            <section class="content" style="margin-top: 2rem;">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="text-danger">ERROR: PAGE NOT FOUND!!!</h2>
                        <a href="{{ route('users.dashboard') }}" class="btn btn-default">Go to Dashboard</a>
                    </div>
                </div>
            </section>
        </div>

        @include('inc.client.footer')
    </div>
@endsection
