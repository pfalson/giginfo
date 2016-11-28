{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('member_id', 'Member_id:') !!}
			{!! Form::text('member_id') !!}
		</li>
		<li>
			{!! Form::label('instrument_id', 'Instrument_id:') !!}
			{!! Form::text('instrument_id') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}