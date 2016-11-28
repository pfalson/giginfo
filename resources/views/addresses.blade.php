{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('street1', 'Street1:') !!}
			{!! Form::text('street1') !!}
		</li>
		<li>
			{!! Form::label('street2', 'Street2:') !!}
			{!! Form::text('street2') !!}
		</li>
		<li>
			{!! Form::label('city_id', 'City_id:') !!}
			{!! Form::text('city_id') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}