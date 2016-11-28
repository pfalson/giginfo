@extends('layouts.modal.form')

@section('modal-form-title')
State Form
@stop

@section('modal-form-content')
	@include('states.fields')
@stop