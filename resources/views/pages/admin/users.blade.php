@extends('layouts.app')

@section('content')
	<div class="wrapper">

		@include('inc.admin.navbar')
		@include('inc.admin.sidebar', ['totalUsers' => count($users), 'active_navlink' => 'users'])

		<div class="content-wrapper">
			<section class="content-header">
				<h1>{{ $title }}</h1>
				<ol class="breadcrumb">
					<li>
						<a href="{{ route('admin.dashboard') }}">
							<i class="fa fa-dashboard"></i> Dashboard
						</a>
					</li>
					<li class="active">Manage Users</li>
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
						@if (count($users) > 0)
							<div class="box box-primary">
								<div class="box-header">
									<h3 class="box-title">All Users</h3>
								</div>
								<div class="box-body">
									<div class="table-responsive">
										<table class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>#</th>
													<th>Image</th>
													<th>Name</th>
													<th>Email</th>
													<th>Phone</th>
													<th>Registered On</th>
												</tr>
											</thead>
											<tbody>
												@php $cnt = 0; @endphp
												@foreach ($users as $user)
													@php $cnt++; @endphp
													<tr>
														<td>{{ $cnt }}</td>
														<td>
															<img src="{{ asset('storage/userImages/' . $user->image) }}" class="img-responsive img-rounded" style="height: 50px; width: 60px;" alt="User Image">
														</td>
														<td>{{ $user->fname . ' ' . $user->lname }}</td>
														<td>{{ $user->email }}</td>
														<td>{{ $user->phone }}</td>
														<td>{{ $user->created_at->isoFormat("MMMM Do, YYYY") }}</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						@else
							<p class="text-danger">No Users Available!</p>
						@endif
					</div>
				</div>
			</section>
		</div>

		@include('inc.admin.footer')
	</div>
@endsection
