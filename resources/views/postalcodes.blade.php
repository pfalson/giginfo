{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('code', 'Code:') !!}
			{!! Form::text('code') !!}
		</li>
		<li>
			{!! Form::label('state_id', 'State_id:') !!}
			{!! Form::text('state_id') !!}
		</li>
		<li>
			{!! Form::label('postallocation_id', 'Postallocation_id:') !!}
			{!! Form::text('postallocation_id') !!}
		</li>
		<li>
			{!! Form::label('longtitude', 'Longtitude:') !!}
			{!! Form::text('longtitude') !!}
		</li>
		<li>
			{!! Form::label('latitude', 'Latitude:') !!}
			{!! Form::text('latitude') !!}
		</li>
		<li>
			{!! Form::label('locationtype_id', 'Locationtype_id:') !!}
			{!! Form::text('locationtype_id') !!}
		</li>
		<li>
			{!! Form::label('postcodetype_id', 'Postcodetype_id:') !!}
			{!! Form::text('postcodetype_id') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}