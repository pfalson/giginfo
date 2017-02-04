<!-- select2 Ajax -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <?php
    /** @noinspection PhpUndefinedVariableInspection */
    $entity_model = $crud->model;
    if (!isset($field['value']))
        $field['value'] = '';
    ?>
    <input type="hidden"
           name="{{ $field['name'] }}" value="{{ $field['value'] }}"
            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2Ajax'])
    >

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
    <!-- include select2 css-->
    <link href="{{ asset('vendor/backpack/select2/select2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/backpack/select2/select2-bootstrap-dick.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <!-- include select2 js-->
    <script src="{{ asset('vendor/backpack/select2/select2.js') }}"></script>
    <script>
        jQuery(document).ready(function($) {
            // trigger select2 for each untriggered select2 box
            $('.select2Ajax').each(function (i, obj) {
                if (!$(obj).data("select2"))
                {
                    $(obj).select2({
                        placeholder: "{{ $field['placeholder'] }}",
                        minimumInputLength: "{{ $field['minimumInputLength'] }}",
                        ajax: {
                            url: "{{ $field['datasource'] }}",
                            dataType: 'json',
                            quietMillis: 250,
                            data: function (term, page) {
                                return {
                                    q: term, // search term
                                    page: page
                                };
                            },
                            results: function (data, params) {
                                params.page = params.page || 1;

                                return {
                                    results: $.map(data.data, function (item) {
                                        textField = "{{$field['attribute']}}";
                                        return {
                                            text: item[textField],
                                            id: item["id"]
                                        }
                                    }),
                                    more: data.current_page < data.last_page
                                };
                            },
                            cache: true
                        },
                        initSelection: function(element, callback) {
                            // the input tag has a value attribute preloaded that points to a preselected repository's id
                            // this function resolves that id attribute to an object that select2 can render
                            // using its formatResult renderer - that way the repository name is shown preselected
                            if ("{{ $field['value'] }}" !== "") {
                                $.ajax("{{ $field['datasource'] }}" + '/' + "{{$field['value']}}", {
                                    dataType: "json"
                                }).done(function(data) {
                                    textField = "{{$field['attribute']}}";
                                    callback({ text: data[textField], id: data["id"] });
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}