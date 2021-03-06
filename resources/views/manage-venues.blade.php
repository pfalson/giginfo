<!DOCTYPE html>
<html>
<head>
	<title>Laravel Vue JS Venue CRUD</title>
	<meta id="token" name="token" value="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css"
		  href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css">
</head>
<body>
<div class="container" id="manage-venues">

	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Laravel Vue JS Venue CRUD</h2>
			</div>
			<div class="pull-right">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-venues">
					Create Venue
				</button>
			</div>
		</div>
	</div>
<!-- Venue Listing -->
	<table class="table table-bordered">
		<tr>
		@foreach ($modelMap as $thing)
			<?php $field = (Array)$thing; ?>
			<th>{{ $field['Field'] }}</th>
		@endforeach

			<th width="200px">Action</th>
		</tr>

		<tr v-for="venues in venuess">
		@foreach ($modelMap as $thing)
			<?php $field = (Array)$thing; ?>
			<td>{{venues.<?=$field['Field']?>}}</td>
		@endforeach

			<td>
				<button class="btn btn-primary" @click.prevent="editVenue(venues)">Edit</button>
				<button class="btn btn-danger" @click.prevent="deleteVenue(venues)">Delete</button>
			</td>
		</tr>

	</table>

	<!-- Pagination -->
	<nav>
		<ul class="pagination">
			<li v-if="pagination.current_page > 1">
				<a href="#" aria-label="Previous"
				   @click.prevent="changePage(pagination.current_page - 1)">
					<span aria-hidden="true">«</span>
				</a>
			</li>
			<li v-for="page in pagesNumber"
				v-bind:class="[ page == isActived ? 'active' : '']">
				<a href="#"
				   @click.prevent="changePage(page)">@{{ page }}</a>
			</li>
			<li v-if="pagination.current_page < pagination.last_page">
				<a href="#" aria-label="Next"
				   @click.prevent="changePage(pagination.current_page + 1)">
					<span aria-hidden="true">»</span>
				</a>
			</li>
		</ul>
	</nav>

<!-- Create Venue Modal -->
	<div class="modal fade" id="create-venues" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">×</span></button>
					<h4 class="modal-title" id="myModalLabel">Create Venue</h4>
				</div>
				<div class="modal-body">

					<form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createVenue">
						@foreach ($modelMap as $thing)
							<div class="form-group input-group">
								<?php
								$field = (Array)$thing;
								echo  Form::label($field['Field'], $field['Field']);
								$disabled = !in_array($field['Field'], $fillable) ? 'disabled' : '';
								if (trim($field['Type']) == 'text') {
									echo Form::textarea($field['Field'], '', ['class'=>"form-control", 'v-model'=>'fillVenue.' . $field['Field'], $disabled]);
								} else if ($field['Type'] == 'tinyint(1)') {
									echo  Form::checkbox($field['Field'], '', ['class'=>"form-control", 'v-model'=>'fillVenue.' . $field['Field'], $disabled]);
								} else {
									echo  Form::text($field['Field'], '', ['class'=>"form-control", 'v-model'=>'fillVenue.' . $field['Field'], $disabled]);
								}
								?>
								<span v-if="formErrorsUpdate[{{$field['Field']}}]"
									  class="error text-danger">@{{ formErrors[$field['Field']] }}</span>
							</div>
					@endforeach
						<div class="form-group">
							{!! Form::submit('Submit'); !!}
						</div>

					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>

<!-- Edit Venue Modal -->
	<div class="modal fade" id="edit-venues" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">×</span></button>
					<h4 class="modal-title" id="myModalLabel">Edit Venue</h4>
				</div>
				<div class="modal-body">
					<form method="POST" enctype="multipart/form-data"
						  v-on:submit.prevent="updateVenue(fillVenue.id)">
						@foreach ($modelMap as $thing)
							<div class="form-group input-group">
								<?php
								$field = (Array)$thing;
								echo  Form::label($field['Field'], $field['Field']);
								$disabled = !in_array($field['Field'], $fillable) ? 'disabled' : '';
								if (trim($field['Type']) == 'text') {
									echo Form::textarea($field['Field'], '', ['class'=>"form-control", 'v-model'=>'fillVenue.' . $field['Field'], $disabled]);
								} else if ($field['Type'] == 'tinyint(1)') {
									echo  Form::checkbox($field['Field'], '', ['class'=>"form-control", 'v-model'=>'fillVenue.' . $field['Field'], $disabled]);
								} else {
									echo  Form::text($field['Field'], '', ['class'=>"form-control", 'v-model'=>'fillVenue.' . $field['Field'], $disabled]);
								}
								?>
								<span v-if="formErrorsUpdate[{{$field['Field']}}]"
									  class="error text-danger">@{{ formErrors[$field['Field']] }}</span>
							</div>
						@endforeach
						<div class="form-group">
							{!! Form::submit('Submit'); !!}
						</div>
					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript"
		src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/vue.resource/0.9.3/vue-resource.min.js"></script>

<script type="text/javascript" src="/js/Venue.js"></script>

</body>
</html>