@extends('layouts.base')
@section('base')
    <div class="col-md-12 spacerBottom">
        <div class="concordia jumbotron">
            <div class="container">
                <div class="center">

                    @include('includes.top')

                </div>

                <div id="main" class="row">

                    @yield('content')

                </div>
            </div>
        </div>
    </div>
@stop
