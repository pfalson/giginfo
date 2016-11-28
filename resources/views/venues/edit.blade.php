@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Venue
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($venue, ['route' => ['venues.update', $venue->id], 'method' => 'patch']) !!}

                        @include('venues.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection