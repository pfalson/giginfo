<!-- bootstrap durationpicker input -->

<?php
// if the column has been cast to Carbon or Date (using attribute casting)
// get the value as a date string
if (isset($field['value']) && ($field['value'] instanceof \Carbon\Carbon || $field['value'] instanceof \Jenssegers\Date\Date))
{
    $field['value'] = $field['value']->format('Y-m-d H:i:s');
}

$field_language = isset($field['duration_picker_options']['language']) ? $field['duration_picker_options']['language'] : \App::getLocale();
?>

@if (isset($entry) && isset($field['start']))
    <input id="start_{{ $field['name'] }}" type="hidden" value="{{ $entry->{$field['start']} }}" />
@endif
<div @include('crud::inc.field_wrapper_attributes') >
    <input type="hidden" name="{{ $field['name'] }}"
           value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}">
    <label>{!! $field['label'] !!}</label>
    <div class="input-group date">
        <input
                name="fake_{{ $field['name'] }}"
                data-bs-durationpicker="{{ isset($field['duration_picker_options']) ? json_encode($field['duration_picker_options']) : '{}'}}"
                type="text"
                @include('crud::inc.field_attributes')
        >
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    <link rel="stylesheet" href="{{ asset('vendor/backpack/jquery-duration-picker/jquery.timepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/backpack/jquery-duration-picker/lib/bootstrap-datepicker.css') }}" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <script src="{{ asset('vendor/backpack/jquery-duration-picker/jquery.timepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/backpack/jquery-duration-picker/lib/bootstrap-datepicker.js') }}"></script>
    <script>
        jQuery(document).ready(function ($) {
            $('[data-bs-durationpicker]').each(function () {
                var $fake = $(this),
                        $field = $fake.parents('.form-group').find('input[type="hidden"]'),
                        $customConfig = $.extend({
//                            default: $field.val()
                            showDuration: true
                        }, $fake.data('bs-durationpicker'));

                $customConfig.locale = $customConfig['language'];
                delete($customConfig['language']);
                var start = $('#start_' + $field[0].name).val();
                $picker = $fake.timepicker({
                    'minTime': new Date().toTimeString().split(" ")[0],
                    'showDuration': true
                });
                $fake.timepicker('setTime', new Date($field.val()));
//                $(this).durationPicker({
//                    hours: {
//                        label: 'hours',
//                        min: 0,
//                        max: 24
//                    },
//                    minutes: {
//                        label: 'minutes',
//                        min: 0,
//                        max: 60
//                    }
////                    classname: "myclass"
//                });

                $fake.on('keydown', function (e) {
                    e.preventDefault();
                    return false;
                });

                $picker.on('change', function (e) {
                    $field.val($fake.val());
                });
            });
        });
    </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
