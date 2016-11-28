<table class="table table-responsive" id="venues-table">
    <thead>
        <th>Name</th>
        <th>Website</th>
        <th>Facebook</th>
        <th>Address Id</th>
        <th>Phone</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($venues as $venue)
        <tr>
            <td>{!! $venue->name !!}</td>
            <td>{!! $venue->website !!}</td>
            <td>{!! $venue->facebook !!}</td>
            <td>{!! $venue->address_id !!}</td>
            <td>{!! $venue->phone !!}</td>
            <td>
                {!! Form::open(['route' => ['venues.destroy', $venue->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('venues.show', [$venue->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('venues.edit', [$venue->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>