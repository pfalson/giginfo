@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Member Instrument
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($memberInstrument, ['route' => ['memberInstruments.update', $memberInstrument->id], 'method' => 'patch']) !!}

                        @include('member_instruments.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection