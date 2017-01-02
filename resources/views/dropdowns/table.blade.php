<table class="table table-responsive" id="members-table">
    <thead>
        <th>Code</th>
        <th>Value</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($dropdowns as $dropdown)
        <tr>
            <td>{!! $dropdown->code !!}</td>
            <td>{!! $dropdown->value !!}</td>
            <td>
                {!! Form::open(['route' => ['dropdowns.destroy', $dropdown->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('dropdowns.show', [$dropdown->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('dropdowns.edit', [$dropdown->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>