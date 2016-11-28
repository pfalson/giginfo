{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('name', 'Name:') !!}
			{!! Form::text('name') !!}
		</li>
		<li>
			{!! Form::label('primary_role', 'Primary_role:') !!}
			{!! Form::text('primary_role') !!}
		</li>
		<li>
			{!! Form::label('biography', 'Biography:') !!}
			{!! Form::textarea('biography') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}