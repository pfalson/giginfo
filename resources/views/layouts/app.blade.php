<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gig Info</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="/css/all.css">
    <script type="text/javascript" href="/js/all.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.3/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="http://raw.githubusercontent.com/hyspace/typeahead.js-bootstrap3.less/master/typeahead.css">

    {{--<!-- Ionicons -->--}}
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src='http://maps.google.com/maps/api/js?libraries=places&key=AIzaSyDCFUSNaAg1mpT8S_GPO-36AmRLNxN7pG4'></script>
    <script>/*! jquery-locationpicker - v0.1.12 - 2015-01-05 */
        /*! jquery-locationpicker - v0.1.15 - 2016-09-26 */
        (function($) {
            function GMapContext(domElement, options) {
                var _map = new google.maps.Map(domElement, options);
                var _marker = new google.maps.Marker({
                    position: new google.maps.LatLng(54.19335, -3.92695),
                    map: _map,
                    title: "Drag Me",
                    visible: options.markerVisible,
                    draggable: options.markerDraggable,
                    icon: options.markerIcon !== undefined ? options.markerIcon : undefined
                });
                return {
                    map: _map,
                    marker: _marker,
                    circle: null,
                    location: _marker.position,
                    radius: options.radius,
                    locationName: options.locationName,
                    addressComponents: {
                        formatted_address: null,
                        addressLine1: null,
                        addressLine2: null,
                        streetName: null,
                        streetNumber: null,
                        city: null,
                        district: null,
                        state: null,
                        stateOrProvince: null
                    },
                    settings: options.settings,
                    domContainer: domElement,
                    geodecoder: new google.maps.Geocoder()
                };
            }
            var GmUtility = {
                drawCircle: function(gmapContext, center, radius, options) {
                    if (gmapContext.circle != null) {
                        gmapContext.circle.setMap(null);
                    }
                    if (radius > 0) {
                        radius *= 1;
                        options = $.extend({
                            strokeColor: "#0000FF",
                            strokeOpacity: .35,
                            strokeWeight: 2,
                            fillColor: "#0000FF",
                            fillOpacity: .2
                        }, options);
                        options.map = gmapContext.map;
                        options.radius = radius;
                        options.center = center;
                        gmapContext.circle = new google.maps.Circle(options);
                        return gmapContext.circle;
                    }
                    return null;
                },
                setPosition: function(gMapContext, location, callback) {
                    gMapContext.location = location;
                    gMapContext.marker.setPosition(location);
                    gMapContext.map.panTo(location);
                    this.drawCircle(gMapContext, location, gMapContext.radius, {});
                    if (gMapContext.settings.enableReverseGeocode) {
                        this.updateLocationName(gMapContext, callback);
                    } else {
                        if (callback) {
                            callback.call(this, gMapContext);
                        }
                    }
                },
                locationFromLatLng: function(lnlg) {
                    return {
                        latitude: lnlg.lat(),
                        longitude: lnlg.lng()
                    };
                },
                addressByFormat: function(addresses, format) {
                    var result = null;
                    for (var i = addresses.length - 1; i >= 0; i--) {
                        if (addresses[i].types.indexOf(format) >= 0) {
                            result = addresses[i];
                        }
                    }
                    return result || addresses[0];
                },
                updateLocationName: function(gmapContext, callback) {
                    gmapContext.geodecoder.geocode({
                        latLng: gmapContext.marker.position
                    }, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK && results.length > 0) {
                            var address = GmUtility.addressByFormat(results, gmapContext.settings.addressFormat);
                            gmapContext.locationName = address.formatted_address;
                            gmapContext.addressComponents = GmUtility.address_component_from_google_geocode(address.address_components);
                        } else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                            return setTimeout(function() {
                                GmUtility.updateLocationName(gmapContext, callback);
                            }, 1e3);
                        }
                        if (callback) {
                            callback.call(this, gmapContext);
                        }
                    });
                },
                address_component_from_google_geocode: function(address_components) {
                    var result = {};
                    for (var i = address_components.length - 1; i >= 0; i--) {
                        var component = address_components[i];
                        if (component.types.indexOf("postal_code") >= 0) {
                            result.postalCode = component.short_name;
                        } else if (component.types.indexOf("street_number") >= 0) {
                            result.streetNumber = component.short_name;
                        } else if (component.types.indexOf("route") >= 0) {
                            result.streetName = component.short_name;
                        } else if (component.types.indexOf("locality") >= 0) {
                            result.city = component.short_name;
                        } else if (component.types.indexOf("sublocality") >= 0) {
                            result.district = component.short_name;
                        } else if (component.types.indexOf("administrative_area_level_1") >= 0) {
                            result.stateOrProvince = component.short_name;
                        } else if (component.types.indexOf("country") >= 0) {
                            result.country = component.short_name;
                        }
                    }
                    result.addressLine1 = [ result.streetNumber, result.streetName ].join(" ").trim();
                    result.addressLine2 = "";
                    return result;
                }
            };
            function isPluginApplied(domObj) {
                return getContextForElement(domObj) != undefined;
            }
            function getContextForElement(domObj) {
                return $(domObj).data("locationpicker");
            }
            function updateInputValues(inputBinding, gmapContext) {
                if (!inputBinding) return;
                var currentLocation = GmUtility.locationFromLatLng(gmapContext.marker.position);
                if (inputBinding.latitudeInput) {
                    inputBinding.latitudeInput.val(currentLocation.latitude).change();
                }
                if (inputBinding.longitudeInput) {
                    inputBinding.longitudeInput.val(currentLocation.longitude).change();
                }
                if (inputBinding.radiusInput) {
                    inputBinding.radiusInput.val(gmapContext.radius).change();
                }
                if (inputBinding.locationNameInput) {
                    inputBinding.locationNameInput.val(gmapContext.locationName).change();
                }
            }
            function setupInputListenersInput(inputBinding, gmapContext) {
                if (inputBinding) {
                    if (inputBinding.radiusInput) {
                        inputBinding.radiusInput.on("change", function(e) {
                            var radiusInputValue = $(this).val();
                            if (!e.originalEvent || isNaN(radiusInputValue)) {
                                return;
                            }
                            gmapContext.radius = radiusInputValue;
                            GmUtility.setPosition(gmapContext, gmapContext.location, function(context) {
                                context.settings.onchanged.apply(gmapContext.domContainer, [ GmUtility.locationFromLatLng(context.location), context.radius, false ]);
                            });
                        });
                    }
                    if (inputBinding.locationNameInput && gmapContext.settings.enableAutocomplete) {
                        var blur = false;
                        gmapContext.autocomplete = new google.maps.places.Autocomplete(inputBinding.locationNameInput.get(0), gmapContext.settings.autocompleteOptions);
                        google.maps.event.addListener(gmapContext.autocomplete, "place_changed", function() {
                            blur = false;
                            var place = gmapContext.autocomplete.getPlace();
                            if (!place.geometry) {
                                gmapContext.settings.onlocationnotfound(place.name);
                                return;
                            }
                            GmUtility.setPosition(gmapContext, place.geometry.location, function(context) {
                                updateInputValues(inputBinding, context);
                                context.settings.onchanged.apply(gmapContext.domContainer, [ GmUtility.locationFromLatLng(context.location), context.radius, false ]);
                            });
                        });
                        if (gmapContext.settings.enableAutocompleteBlur) {
                            inputBinding.locationNameInput.on("change", function(e) {
                                if (!e.originalEvent) {
                                    return;
                                }
                                blur = true;
                            });
                            inputBinding.locationNameInput.on("blur", function(e) {
                                if (!e.originalEvent) {
                                    return;
                                }
                                setTimeout(function() {
                                    var address = $(inputBinding.locationNameInput).val();
                                    if (address.length > 5 && blur) {
                                        blur = false;
                                        gmapContext.geodecoder.geocode({
                                            address: address
                                        }, function(results, status) {
                                            if (status == google.maps.GeocoderStatus.OK && results && results.length) {
                                                GmUtility.setPosition(gmapContext, results[0].geometry.location, function(context) {
                                                    updateInputValues(inputBinding, context);
                                                    context.settings.onchanged.apply(gmapContext.domContainer, [ GmUtility.locationFromLatLng(context.location), context.radius, false ]);
                                                });
                                            }
                                        });
                                    }
                                }, 1e3);
                            });
                        }
                    }
                    if (inputBinding.latitudeInput) {
                        inputBinding.latitudeInput.on("change", function(e) {
                            var latitudeInputValue = $(this).val();
                            if (!e.originalEvent || isNaN(latitudeInputValue)) {
                                return;
                            }
                            GmUtility.setPosition(gmapContext, new google.maps.LatLng(latitudeInputValue, gmapContext.location.lng()), function(context) {
                                context.settings.onchanged.apply(gmapContext.domContainer, [ GmUtility.locationFromLatLng(context.location), context.radius, false ]);
                                updateInputValues(gmapContext.settings.inputBinding, gmapContext);
                            });
                        });
                    }
                    if (inputBinding.longitudeInput) {
                        inputBinding.longitudeInput.on("change", function(e) {
                            var longitudeInputValue = $(this).val();
                            if (!e.originalEvent || isNaN(longitudeInputValue)) {
                                return;
                            }
                            GmUtility.setPosition(gmapContext, new google.maps.LatLng(gmapContext.location.lat(), longitudeInputValue), function(context) {
                                context.settings.onchanged.apply(gmapContext.domContainer, [ GmUtility.locationFromLatLng(context.location), context.radius, false ]);
                                updateInputValues(gmapContext.settings.inputBinding, gmapContext);
                            });
                        });
                    }
                }
            }
            function autosize(gmapContext) {
                google.maps.event.trigger(gmapContext.map, "resize");
                setTimeout(function() {
                    gmapContext.map.setCenter(gmapContext.marker.position);
                }, 300);
            }
            function updateMap(gmapContext, $target, options) {
                var settings = $.extend({}, $.fn.locationpicker.defaults, options), latNew = settings.location.latitude, lngNew = settings.location.longitude, radiusNew = settings.radius, latOld = gmapContext.settings.location.latitude, lngOld = gmapContext.settings.location.longitude, radiusOld = gmapContext.settings.radius;
                if (latNew == latOld && lngNew == lngOld && radiusNew == radiusOld) return;
                gmapContext.settings.location.latitude = latNew;
                gmapContext.settings.location.longitude = lngNew;
                gmapContext.radius = radiusNew;
                GmUtility.setPosition(gmapContext, new google.maps.LatLng(gmapContext.settings.location.latitude, gmapContext.settings.location.longitude), function(context) {
                    setupInputListenersInput(gmapContext.settings.inputBinding, gmapContext);
                    context.settings.oninitialized($target);
                });
            }
            $.fn.locationpicker = function(options, params) {
                if (typeof options == "string") {
                    var _targetDomElement = this.get(0);
                    if (!isPluginApplied(_targetDomElement)) return;
                    var gmapContext = getContextForElement(_targetDomElement);
                    switch (options) {
                        case "location":
                            if (params == undefined) {
                                var location = GmUtility.locationFromLatLng(gmapContext.location);
                                location.radius = gmapContext.radius;
                                location.name = gmapContext.locationName;
                                return location;
                            } else {
                                if (params.radius) {
                                    gmapContext.radius = params.radius;
                                }
                                GmUtility.setPosition(gmapContext, new google.maps.LatLng(params.latitude, params.longitude), function(gmapContext) {
                                    updateInputValues(gmapContext.settings.inputBinding, gmapContext);
                                });
                            }
                            break;

                        case "subscribe":
                            if (params == undefined) {
                                return null;
                            } else {
                                var event = params.event;
                                var callback = params.callback;
                                if (!event || !callback) {
                                    console.error('LocationPicker: Invalid arguments for method "subscribe"');
                                    return null;
                                }
                                google.maps.event.addListener(gmapContext.map, event, callback);
                            }
                            break;

                        case "map":
                            if (params == undefined) {
                                var locationObj = GmUtility.locationFromLatLng(gmapContext.location);
                                locationObj.formattedAddress = gmapContext.locationName;
                                locationObj.addressComponents = gmapContext.addressComponents;
                                return {
                                    map: gmapContext.map,
                                    marker: gmapContext.marker,
                                    location: locationObj
                                };
                            } else {
                                return null;
                            }

                        case "autosize":
                            autosize(gmapContext);
                            return this;
                    }
                    return null;
                }
                return this.each(function() {
                    var $target = $(this);
                    if (isPluginApplied(this)) {
                        updateMap(getContextForElement(this), $(this), options);
                        return;
                    }
                    var settings = $.extend({}, $.fn.locationpicker.defaults, options);
                    var gmapContext = new GMapContext(this, $.extend({}, settings.mapOptions, {
                        zoom: settings.zoom,
                        center: new google.maps.LatLng(settings.location.latitude, settings.location.longitude),
                        mapTypeId: settings.mapTypeId,
                        mapTypeControl: false,
                        styles: settings.styles,
                        disableDoubleClickZoom: false,
                        scrollwheel: settings.scrollwheel,
                        streetViewControl: false,
                        radius: settings.radius,
                        locationName: settings.locationName,
                        settings: settings,
                        autocompleteOptions: settings.autocompleteOptions,
                        addressFormat: settings.addressFormat,
                        draggable: settings.draggable,
                        markerIcon: settings.markerIcon,
                        markerDraggable: settings.markerDraggable,
                        markerVisible: settings.markerVisible
                    }));
                    $target.data("locationpicker", gmapContext);
                    function displayMarkerWithSelectedArea() {
                        GmUtility.setPosition(gmapContext, gmapContext.marker.position, function(context) {
                            var currentLocation = GmUtility.locationFromLatLng(gmapContext.location);
                            updateInputValues(gmapContext.settings.inputBinding, gmapContext);
                            context.settings.onchanged.apply(gmapContext.domContainer, [ currentLocation, context.radius, true ]);
                        });
                    }
                    if (settings.markerInCenter) {
                        gmapContext.map.addListener("bounds_changed", function() {
                            if (!gmapContext.marker.dragging) {
                                gmapContext.marker.setPosition(gmapContext.map.center);
                                updateInputValues(gmapContext.settings.inputBinding, gmapContext);
                            }
                        });
                        gmapContext.map.addListener("idle", function() {
                            if (!gmapContext.marker.dragging) {
                                displayMarkerWithSelectedArea();
                            }
                        });
                    }
                    google.maps.event.addListener(gmapContext.marker, "drag", function(event) {
                        updateInputValues(gmapContext.settings.inputBinding, gmapContext);
                    });
                    google.maps.event.addListener(gmapContext.marker, "dragend", function(event) {
                        displayMarkerWithSelectedArea();
                    });
                    GmUtility.setPosition(gmapContext, new google.maps.LatLng(settings.location.latitude, settings.location.longitude), function(context) {
                        updateInputValues(settings.inputBinding, gmapContext);
                        setupInputListenersInput(settings.inputBinding, gmapContext);
                        context.settings.oninitialized($target);
                    });
                });
            };
            $.fn.locationpicker.defaults = {
                location: {
                    latitude: 40.7324319,
                    longitude: -73.82480777777776
                },
                locationName: "",
                radius: 500,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: [],
                mapOptions: {},
                scrollwheel: true,
                inputBinding: {
                    latitudeInput: null,
                    longitudeInput: null,
                    radiusInput: null,
                    locationNameInput: null
                },
                enableAutocomplete: false,
                enableAutocompleteBlur: false,
                autocompleteOptions: null,
                addressFormat: "postal_code",
                enableReverseGeocode: true,
                draggable: true,
                onchanged: function(currentLocation, radius, isMarkerDropped) {},
                onlocationnotfound: function(locationName) {},
                oninitialized: function(component) {},
                markerIcon: undefined,
                markerDraggable: true,
                markerVisible: true
            };
        })(jQuery);
    </script>
    <script src="/js/locationpicker.jquery.js"></script>
    @yield('css')
</head>

<body class="skin-blue sidebar-mini">
@if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <b>Gig Info</b>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="/img/giginfo_logo.png"
                                     class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{!! Auth::user()->name !!}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="/img/giginfo_logo.png"
                                         class="img-circle" alt="User Image"/>
                                    <p>
                                        {!! Auth::user()->name !!}
                                        <small>Member since {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Sign out
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright © 2016 <a href="#">Company</a>.</strong> All rights reserved.
        </footer>

    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{!! url('/') !!}">
                    Gig Info
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{!! url('/home') !!}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{!! url('/login') !!}">Login</a></li>
{{--                    <li><a href="{!! url('/register') !!}">Register</a></li>--}}
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- jQuery 2.1.4 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>

    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.3/js/app.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>