<?php
$entity_model = $crud->getModel();

//for update form, get initial state of the entity
if (isset($id) && $id)
{
    $entity_column = $entity_model::find($id)->getAttributes();
}

$googleApiKey = isset($field['google_api_key']) ? $field['google_api_key'] : (config('backpack.google_api_key', env('GOOGLE_API_KEY', null)));

$notification = new stdClass();
$notification->title = trans('backpack::crud.address_google_error_title');
$notification->message = trans('backpack::crud.address_google_error_message');
?>

<div @include('crud::inc.field_wrapper_attributes')>
    @if (isset($field['label']))
        <label>{!! $field['label'] !!}</label>
    @endif
    <input
            type="text"
            name="{{ $field['name'] }}"
            id="{{ $field['name'] }}"
            value="{{ old($field['name'], isset($entity_column[$field['name']]) ? $entity_column[$field['name']] : '') }}"
            @include('crud::inc.field_attributes')
    >
    <div id="map" style="height: 300px"></div>
    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

@foreach ($field['components'] as $name => $attribute)

    @if (!isset($attribute['field_type']))
        <?php  $attribute['field_type'] = 'text'; ?>
    @endif
    @if ($attribute['field_type'] !== 'hidden')
        <div @include('crud::inc.field_wrapper_attributes') >
            @if (isset($attribute['label']))
                <label>{!! $attribute['label'] !!}</label>
            @endif
    @endif
            <input
                    type="{{ $attribute['field_type'] }}"
                    name="{{ $name }}"
                    id="{{ $name }}"
                    value="{{ old($name, isset($entity_column[$name]) ? $entity_column[$name] : null) }}"
                    @include('crud::inc.field_attributes')
            >
            @if ($attribute['field_type'] !== 'hidden')
        </div>
    @endif

@endforeach

{{-- Note: you can use  to only load some CSS/JS once, even though there are multiple instances of it --}}

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}

    {{-- @push('crud_fields_styles')
        <!-- no styles -->
    @endpush --}}

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <script src="/js/getTimeZone.js"></script>
    <script>

        var field =
                {!! json_encode($field) !!}
        var notification =
                {!! json_encode($notification) !!}

        map = null;
        var input = null;

        function setCurrentLocation() {
            var infoWindow = new google.maps.InfoWindow({map: map});

            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    infoWindow.setPosition(pos);
                    infoWindow.setContent('Location found.');
                    map.setCenter(pos);
                }, function () {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        }

        function initAutocomplete() {
            if (document.getElementById(field.name)) {

                var lat = {{ old('latitude', isset($entity_column['latitude']) ? $entity_column['latitude'] : $field['lat']) }};
                var lng = {{ old('longitude', isset($entity_column['longitude']) ? $entity_column['longitude'] : $field['long']) }};
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: lat, lng: lng},
                    zoom: {{ old('latitude', isset($entity_column['latitude']) ? 18 : 13) }}
                });

                var marker = new google.maps.Marker({
                    position: map.center,
                    map: map
                });

                var infoWindow = new google.maps.InfoWindow({map: map});

                @if (isset($field['current']) && $field['current'])
                    setCurrentLocation();
                @endif

                input = document.getElementById(field.name);

                var geocoder = new google.maps.Geocoder();
                var autocomplete = new google.maps.places.Autocomplete((input){!! isset($field['address_type']) ? ", {types: ['" . $field['address_type'] . "']}" : "" !!});
                autocomplete.addListener('place_changed', function () {
                    fillInAddress(autocomplete)
                });
                autocomplete.bindTo('bounds', map);
                google.maps.event.addListener(map, 'click', function (event) {
                    geocoder.geocode({
                        'latLng': event.latLng
                    }, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                input.value = results[0].formatted_address;
                            }
                        }
                    });
                });
            }
        }

        function fillInAddress(autocomplete) {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();
            var val = [];
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }

            if (place.address_components) {
                var address = [];
                // Get each component of the address from the place details
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    address[addressType] = place.address_components[i];
                }
            } else {
                $(function () {
                    new PNotify({
                        title: notification['title'],
                        text: notification['message'],
                        icon: false,
                    });
                });
            }

            // Fill the corresponding field on the form if it exists.
            for (var component in field.components) {
                var property = field.components[component];
                var readOnly = false;
                if (typeof property.readOnly !== 'undefined') {
                    readOnly = property.readOnly;
                }
                document.getElementById(component).readOnly = readOnly;
                var value = place;
                if (typeof property.category !== 'undefined') {
                    if (property.category == 'address_components') {
                        value = address;
                    } else {
                        value = value[property.category];
                    }
                }
                value = value[property.name];
                if (typeof property.type !== 'undefined') {
                    value = value[property.type];
                }
                if (typeof property.function !== 'undefined') {
                    value = value[property.function]();
                }
                if (value) {
                    document.getElementById(component).value = value;
                } else {
                    document.getElementById(component).value = '';
                }
            }
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                    'Error: The Geolocation service failed.' :
                    'Error: Your browser doesn\'t support geolocation.');
        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $googleApiKey }}&amp;libraries=places&amp;callback=initAutocomplete"
            async defer></script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}