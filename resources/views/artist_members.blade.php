{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('artist_id', 'Artist_id:') !!}
			{!! Form::text('artist_id') !!}
		</li>
		<li>
			{!! Form::label('member_id', 'Member_id:') !!}
			{!! Form::text('member_id') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}