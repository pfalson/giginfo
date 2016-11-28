{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('artist_id', 'Artist_id:') !!}
			{!! Form::text('artist_id') !!}
		</li>
		<li>
			{!! Form::label('venue_id', 'Venue_id:') !!}
			{!! Form::text('venue_id') !!}
		</li>
		<li>
			{!! Form::label('start', 'Start:') !!}
			{!! Form::text('start') !!}
		</li>
		<li>
			{!! Form::label('finish', 'Finish:') !!}
			{!! Form::text('finish') !!}
		</li>
		<li>
			{!! Form::label('description', 'Description:') !!}
			{!! Form::text('description') !!}
		</li>
		<li>
			{!! Form::label('poster', 'Poster:') !!}
			{!! Form::text('poster') !!}
		</li>
		<li>
			{!! Form::label('price', 'Price:') !!}
			{!! Form::text('price') !!}
		</li>
		<li>
			{!! Form::label('age', 'Age:') !!}
			{!! Form::text('age') !!}
		</li>
		<li>
			{!! Form::label('type', 'Type:') !!}
			{!! Form::text('type') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}