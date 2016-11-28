<table class="table table-responsive" id="streets-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($streets as $street)
        <tr>
            <td>{!! $street->name !!}</td>
            <td>
                {!! Form::open(['route' => ['streets.destroy', $street->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('streets.show', [$street->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('streets.edit', [$street->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>