@extends('backpack::layout')

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="box">
				<div class="box-body row">
					<!-- load the view from the application if it exists, otherwise load the one in the package -->
					@if(view()->exists('vendor.backpack.crud.form_content'))
						@include('vendor.backpack.crud.form_content')
					@else
						@include('crud::form_content', ['fields' => $crud->getFields('update', $entry->getKey())])
					@endif
				</div><!-- /.box-body -->
				<div class="box-footer">

					<button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> {{ trans('backpack::crud.save') }}</span></button>
					<a href="{{ url($crud->route) }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">{{ trans('backpack::crud.cancel') }}</span></a>
				</div><!-- /.box-footer-->
			</div><!-- /.box -->
		</div>
	</div>
@endsection