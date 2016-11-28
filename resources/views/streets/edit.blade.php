@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Street
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($street, ['route' => ['streets.update', $street->id], 'method' => 'patch']) !!}

                        @include('streets.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection