{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('name', 'Name:') !!}
			{!! Form::text('name') !!}
		</li>
		<li>
			{!! Form::label('website', 'Website:') !!}
			{!! Form::text('website') !!}
		</li>
		<li>
			{!! Form::label('facebook', 'Facebook:') !!}
			{!! Form::text('facebook') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}