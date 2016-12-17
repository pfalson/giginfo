@extends('layouts.app')

@section('content')
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet"></link>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css" rel="stylesheet"></link>

    <script src="/js/placepicker.js"></script>

    <script>
        $(document).ready(function() {
            var directionsDisplay = new google.maps.DirectionsRenderer();
            var directionsService = new google.maps.DirectionsService();

            var locations = [
                    @foreach($gigs as $gig)
                    ['{{ $gig->info }}', {{ $gig->latitude }}, {{ $gig->longitude }}, {{ $gig->id }}],
                @endforeach
            ];
// arrays to hold copies of the markers and html used by the side_bar
// because the function closure trick doesnt work there
            var gmarkers = [];
            var htmls = [];

// arrays to hold variants of the info window html with get direction forms open
            var to_htmls = [];
            var from_htmls = [];
            var i = locations.length;

            var location = new google.maps.LatLng({{ $postalcode->latitude }}, {{ $postalcode->longitude }});
            latlng = location;

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: location,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    url: 'http://giginfo.org/gigs/' + locations[i][3]
                });

                google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
                    return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));

                google.maps.event.addListener(marker, 'click', function() {
                    window.location.href = this.url;
                });
            }

            directionsDisplay.setMap(map);
            directionsDisplay.setPanel(document.getElementById("directionsPanel"));

            $.get("http://ipinfo.io", function (response) {
                $("#ip").html("IP: " + response.ip);
                $("#address").html("Location: " + response.city + ", " + response.region);
                $("#details").html(JSON.stringify(response, null, 4));
            }, "jsonp");
            $(".demomapviewplacepicker").placepicker();
        });

    </script>
    <style>
        .placepicker-map {
            width: 100%;
            height: 300px;
        }
    </style>

    <section class="content-header">
        <h1 class="pull-left">Gigs</h1>
        {{--<h1 class="pull-right">--}}
        {{--<a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('gigs.create') !!}">Add New</a>--}}
        {{--</h1>--}}
    </section>
    <div class="content">
        @include('flash::message')

        <div class="clearfix"></div>
        <div class="clearfix">
        </div>

        <div class="box box-primary">

            <div class="box-body">
                {{--{{ Form::label('map', 'Map') }}--}}
                {{--{{ Form::radio('method', 'Map', true) }}--}}
                {{--{{ Form::label('table', 'Table') }}--}}
                {{--{{ Form::radio('method', 'Table') }}--}}

                <div id="map" style="width: 500px; height: 400px;">
                    {{--@include('gigs.browse_map')--}}
                    <div id="directionsPanel"></div>
                </div>
                <div class="form-group">
                    <input class="demomapviewplacepicker form-control" data-map-container-id="collapseOne" />
                </div>

                <div id="table">
                    @include('gigs.browse_table')
                </div>
            </div>
        </div>
    </div>
@endsection

