@extends('layouts.base')
@section('base')
	<div class="concordia jumbotron">
		<div class="container">
			<div class="col-md-6 spacerBottom">
				<div class="center">

					@include('includes.top')

				</div>

				<div id="main" class="row">

					@yield('content')

				</div>

				<div id="main" class="row">
					@include('includes.logoutButton')

				</div>
			</div>
			<div class="col-md-6  text-center">
				<div class="container text-right">
					@include('includes.logoutButton')
				</div>
				<div class="text-center">

					<footer class="row">

						@include('includes.links')

					</footer>
				</div>
			</div>
		</div>
	</div>
@stop
