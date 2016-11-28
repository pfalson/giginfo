{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('artist_id', 'Artist_id:') !!}
			{!! Form::text('artist_id') !!}
		</li>
		<li>
			{!! Form::label('genre_id', 'Genre_id:') !!}
			{!! Form::text('genre_id') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}