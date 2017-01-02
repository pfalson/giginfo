@extends('layouts.app')

@section('content')
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet"></link>
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css" rel="stylesheet"></link>
    <script src="../vendor/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript"
            src="../vendor/adminlte/plugins/daterangepicker/moment.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.42/js/bootstrap-datetimepicker.min.js"></script>

    <style>
        .select2-container, .select2-choices {
            height: 200px;
            width: 1000px;
        }
    </style>

    <script>
        var zoomLevel = radiusToZoom({{ $distance }});

        function radiusToZoom(radius) {
            return Math.round(14 - Math.log(radius) / Math.LN2);
        }

        function showMap() {
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

            var location = new google.maps.LatLng({{ $latitude }}, {{ $longitude }});
            latlng = location;

            var mapobj = document.getElementById('map');
            var map = new google.maps.Map(mapobj, {
                zoom: zoomLevel,
                center: location,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    url: 'https://giginfo.org/gigs/' + locations[i][3]
                });

                google.maps.event.addListener(marker, 'mouseover', (function (marker, i) {
                    return function () {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));

                google.maps.event.addListener(marker, 'click', function () {
                    window.location.href = this.url;
                });
            }

            var directions = document.getElementById("directionsPanel");
            if (typeof directions !== 'undefined') {
                directionsDisplay.setMap(map);
                directionsDisplay.setPanel(directions);
            }
        }
    </script>
    <style>
        .placepicker-map {
            width: 100%;
            height: 300px;
        }

        div > * {
            vertical-align: middle;
            line-height: normal;
        }
    </style>

    <section class="content-header">
        <h1 class="pull-left">Gigs</h1>
        {{--<h1 class="pull-right">--}}
        {{--<a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('gigs.create') !!}">Add New</a>--}}
        {{--</h1>--}}
    </section>
    <form id='form' method="POST" action="{{ route('gigs.index') }}">
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <p></p>
        <div id="div_showFilter" class='css_button'>
            <div id="showFilter">{{ $showFilterHidden == 'none' ? 'Show' : 'Hide' }} Filter</div>
            <input type="hidden" id="showFilterHidden" name="showFilterHidden" value="{{ $showFilterHidden }}">
            <input type="hidden" id="showMapHidden" name="showMapHidden" value="{{ $showMapHidden }}">
            <input type="hidden" id="latitude" name="latitude" value="{{ $latitude }}">
            <input type="hidden" id="longitude" name="longitude" value="{{ $longitude }}">
        </div>
        <p></p>
        <div id="content" class="content" style="display: {{ $showFilterHidden }}">
            @include('flash::message')

            <div class="clearfix"></div>
            <div class="clearfix"></div>
            <p></p>
            <div class="form-group">
                <span><b>{{ trans('backpack::crud.filter') }}:</b></span>
                <div id="div_apply" class='css_button'>
                    <div id="apply">Apply</div>
                </div>
                <div id="div_reset" class='css_button'>
                    <div id="reset">Reset</div>
                </div>
                <div style="margin-top: 15px;">
                    <div class="inline">
                        <label>When:&nbsp;&nbsp;</label>
                        {!! Form::label('today', 'Today') !!}
                        {!! Form::checkbox('today', 1, $today, ['style' => 'margin-bottom:8px;']) !!}
                    </div>
                    <div id="date_range" class="inline" style="margin-left: 10px;">
                        <div style="margin-left: 60px;">
                            <div class="form-group inline">
                                <input type="hidden" id="start" name="start" value="{{ $start }}">
                                <label>From</label>
                                <div class="input-group date" style="display: inline-block;">
                                    <input
                                            name="fake_start"
                                            data-bs-datetimepicker="{}"
                                            type="text"
                                            class="form-control" style="width: 100px;height: 30px;"
                                    >
                                </div>
                            </div>
                            <div class="form-group inline">
                                <input type="hidden" id="finish" name="finish" value="{{ $finish }}">
                                <label>To</label>
                                <div class="input-group date" style="display: inline-block;">
                                    <input
                                            name="fake_finish"
                                            data-bs-datetimepicker="{}"
                                            type="text"
                                            class="form-control" style="width: 100px;height: 30px;"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inline">
                <label>Type:&nbsp;&nbsp;</label>
            </div>
            <div class="inline">
                <label style="font-weight: normal">
                    <input id="all" type="radio" name="venue_type" value="all">
                    {{ trans('backpack::crud.all') }}
                </label>
                <label style="font-weight: normal">
                    <input id="Establishment" type="radio" name="venue_type" value="Establishment">
                    {{ trans('backpack::crud.establishment') }}
                </label>
                <label style="font-weight: normal">
                    <input id="House" type="radio" name="venue_type" value="House">
                    {{ trans('backpack::crud.house_party') }}
                </label>
            </div>
            <div style="margin: 10px 0px 10px 0px;">
                {!! Form::label('distance', 'Distance:') !!}
                <input type="number" name="distance" id="distance"
                       value="{{{ $distance }}}" style="width: 60px; margin-bottom: 5px;"/>
            </div>
            <div>
                <div style="margin: 10px 0px 10px 0px">
                    {!! Form::label('genre', 'Genre:', ['style' => 'width: 60px']) !!}
                    {{ Form::select('genre[]', \App\Models\Genre::all()->pluck('value', 'id')->toArray(), $genre,['id' => 'genre', 'class' => 'select2', 'multiple' => true, 'style' => 'display: none;']) }}
                </div>
                <div style="margin: 10px 0px 10px 0px">
                    {!! Form::label('artist', 'Artist:', ['style' => 'width: 60px']) !!}
                    {{ Form::select('artist[]', $artists, $artist,[ 'class' => 'select2', 'multiple' => true, 'style' => 'display: none;']) }}
                </div>
            </div>
        </div>
    </form>
    <div id="main">
        <div id="div_showMap" class='css_button'>
            <div id="showMap">{{ $showMapHidden == 'none' ? 'Show' : 'Hide' }} Map</div>
        </div>
        <p></p>
        <div class="box box-primary">
            <div class="box-body">
                <div id="map" style="width: 100%; height: 400px; display: {{ $showMapHidden }};">
                </div>
                <div id="table">
                    @include('gigs.browse_table')
                </div>
            </div>
        </div>
    </div>
    <div id="currentLocation">
    </div>
@endsection
@section('scripts')
    <script>
        var mapDrawn = false;
        var showFilterBtn = $('#showFilter');
        var showFilterHidden = $('#showFilterHidden');
        showFilterBtn.click(function () {
            var filterDiv = $('#content');
            if (showFilterBtn.text() === 'Show Filter') {
                filterDiv.show();
                showFilterBtn.text('Hide Filter');
            } else {
                filterDiv.hide();
                showFilterBtn.text('Show Filter');
            }
            showFilterHidden.val(filterDiv.css('display'));
        });

        var showMapBtn = $('#showMap');
        var showMapHidden = $('#showMapHidden');
        var mapDiv = $('#map');
        showMapBtn.click(function () {
            if (showMapHidden.val() === 'none') {
                mapDiv.show();
                showMap();
                showMapBtn.text('Hide Map');
            } else {
                mapDiv.hide();
                showMapBtn.text('Show Map');
            }
            showMapHidden.val(mapDiv.css('display'));
        });
        if (mapDiv.css('display') !== 'none') {
            showMap();
        }
    </script>
    <script src="https://giginfo.org/vendor/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript"
            src="https://giginfo.org/vendor/adminlte/plugins/daterangepicker/moment.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.42/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        var dateFormat = function () {
            var a = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g, b = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g, c = /[^-+\dA-Z]/g, d = function (a, b) {
                for (a = String(a), b = b || 2; a.length < b;)a = "0" + a;
                return a
            };
            return function (e, f, g) {
                var h = dateFormat;
                if (1 != arguments.length || "[object String]" != Object.prototype.toString.call(e) || /\d/.test(e) || (f = e, e = void 0), e = e ? new Date(e) : new Date, isNaN(e))throw SyntaxError("invalid date");
                f = String(h.masks[f] || f || h.masks.default), "UTC:" == f.slice(0, 4) && (f = f.slice(4), g = !0);
                var i = g ? "getUTC" : "get", j = e[i + "Date"](), k = e[i + "Day"](), l = e[i + "Month"](), m = e[i + "FullYear"](), n = e[i + "Hours"](), o = e[i + "Minutes"](), p = e[i + "Seconds"](), q = e[i + "Milliseconds"](), r = g ? 0 : e.getTimezoneOffset(), s = {
                    d: j,
                    dd: d(j),
                    ddd: h.i18n.dayNames[k],
                    dddd: h.i18n.dayNames[k + 7],
                    m: l + 1,
                    mm: d(l + 1),
                    mmm: h.i18n.monthNames[l],
                    mmmm: h.i18n.monthNames[l + 12],
                    yy: String(m).slice(2),
                    yyyy: m,
                    h: n % 12 || 12,
                    hh: d(n % 12 || 12),
                    H: n,
                    HH: d(n),
                    M: o,
                    MM: d(o),
                    s: p,
                    ss: d(p),
                    l: d(q, 3),
                    L: d(q > 99 ? Math.round(q / 10) : q),
                    t: n < 12 ? "a" : "p",
                    tt: n < 12 ? "am" : "pm",
                    T: n < 12 ? "A" : "P",
                    TT: n < 12 ? "AM" : "PM",
                    Z: g ? "UTC" : (String(e).match(b) || [""]).pop().replace(c, ""),
                    o: (r > 0 ? "-" : "+") + d(100 * Math.floor(Math.abs(r) / 60) + Math.abs(r) % 60, 4),
                    S: ["th", "st", "nd", "rd"][j % 10 > 3 ? 0 : (j % 100 - j % 10 != 10) * j % 10]
                };
                return f.replace(a, function (a) {
                    return a in s ? s[a] : a.slice(1, a.length - 1)
                })
            }
        }();
        dateFormat.masks = {
            default: "ddd mmm dd yyyy HH:MM:ss",
            shortDate: "m/d/yy",
            mediumDate: "mmm d, yyyy",
            longDate: "mmmm d, yyyy",
            fullDate: "dddd, mmmm d, yyyy",
            shortTime: "h:MM TT",
            mediumTime: "h:MM:ss TT",
            longTime: "h:MM:ss TT Z",
            isoDate: "yyyy-mm-dd",
            isoTime: "HH:MM:ss",
            isoDateTime: "yyyy-mm-dd'T'HH:MM:ss",
            isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
        }, dateFormat.i18n = {
            dayNames: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
        }, Date.prototype.format = function (a, b) {
            return dateFormat(this, a, b)
        };

        jQuery(document).ready(function ($) {
            // trigger select2 for each untriggered select2_multiple box
            $('.select2').each(function (i, obj) {
                if (!$(obj).data("select2")) {
                    $(obj).select2();
                }
            });
            $('.select2-container').each(function (i, obj) {
                $(obj).width(400).height(50);
            });
            $('.select2-search').each(function (i, obj) {
                $(obj).width(400).height(50);
            });


            $('[data-bs-datetimepicker]').each(function () {

                var $fake = $(this),
                        $field = $fake.parents('.form-group').find('input[type="hidden"]'),
                        $customConfig = $.extend({
                            format: 'MM/DD/YYYY',
                            defaultDate: $field.val()
                        }, $fake.data('bs-datetimepicker'));

                $customConfig.locale = $customConfig['language'];
                delete($customConfig['language']);
                $picker = $fake.datetimepicker($customConfig);

                $fake.on('keydown', function (e) {
                    e.preventDefault();
                    return false;
                });

                $picker.on('dp.change', function (e) {
                    var sqlDate = e.date.format('YYYY-MM-DD');
                    $field.val(sqlDate).change();
                });
            });

            var today = $('input[name=today]');
            today.change(function () {
                $("#date_range :input").attr("disabled", today.prop('checked'));
            }).trigger();

        });

        $('#reset').click(function () {
            $(':input', '#form')
                    .not(':button, :submit, :reset')
                    .val('')
                    .removeAttr('checked')
                    .removeAttr('selected');
            $('#all').prop('checked', true);
            $('#distance').val(20);
        });

        $('#apply').click(function () {
            $('#form').submit();
        });

        $('#{{ $venue_type }}').prop('checked', true);
    </script>
@endsection