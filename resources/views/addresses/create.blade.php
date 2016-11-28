@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Address
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'addresses.store']) !!}

                        @include('addresses.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Typeahead.js Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script>
        jQuery(document).ready(function ($) {
            // Set the Options for "Bloodhound" suggestion engine
            var engine = new Bloodhound({
                remote: {
                    url: '/find/cities?name=%%QUERY%%',
                    wildcard: '%QUERY%'
                },
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace
            });

            $("#city").typeahead({
                hint: true,
                autoSelect: true,
                highlight: true,
                minLength: 1
            }, {
                source: engine.ttAdapter(),

                // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'id',
                displayKey: 'name',
                autoSelect: true,
                limit: 15,
                // the key from the array we want to display (name,id,email,etc...)
                templates: {
                    empty: [
                        '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                    ],
                    suggestion: function (data) {
                        return '<div class="list-group-item">' + data.name + '</div>'
                    }
                }
            }).bind('typeahead:selected', function (ev, suggestion) {
                $("#city_id").val(suggestion.id);
            });
        });
    </script>
    <script>
        jQuery(document).ready(function ($) {
            // Set the Options for "Bloodhound" suggestion engine
            var engine = new Bloodhound({
                remote: {
                    url: '/find/streets?name=%%QUERY%%',
                    wildcard: '%QUERY%'
                },
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace
            });

            $("#street").typeahead({
                hint: true,
                autoSelect: true,
                highlight: true,
                minLength: 1
            }, {
                source: engine.ttAdapter(),

                // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'id',
                displayKey: 'name',
                autoSelect: true,
                limit: 15,
                // the key from the array we want to display (name,id,email,etc...)
                templates: {
                    empty: [
                        '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                    ],
                    suggestion: function (data) {
                        return '<div class="list-group-item">' + data.name + '</div>'
                    }
                }
            }).bind('typeahead:selected', function (ev, suggestion) {
                $("#street_id").val(suggestion.id);
            });
        });
    </script>
@endsection
