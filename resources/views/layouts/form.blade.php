@extends('layouts.base')
@section('base')
    <div class="spacerBottom">
        <div class="jumbotron">
            <div class="container">
                <div class="row">

                    @include('includes.top')

                </div>

                <div id="main">

                    @yield('content')

                </div>
            </div>
        </div>
    </div>
@stop
