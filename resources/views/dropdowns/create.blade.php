@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            {{ $tableName }}
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => $table . '.store']) !!}

                        @include('dropdowns.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
    $("#code").keyup(function() {
        $("#value").val(toTitleCase($(this).val()));
    });

    function toTitleCase(str) {
        return str.replace(/(?:^|\s)\w/g, function(match) {
            return match.toUpperCase();
        });
    }
    </script>
@endsection