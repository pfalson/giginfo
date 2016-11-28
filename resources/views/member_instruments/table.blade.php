<table class="table table-responsive" id="memberInstruments-table">
    <thead>
        <th>Member Id</th>
        <th>Instrument Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($memberInstruments as $memberInstrument)
        <tr>
            <td>{!! $memberInstrument->member_id !!}</td>
            <td>{!! $memberInstrument->instrument_id !!}</td>
            <td>
                {!! Form::open(['route' => ['memberInstruments.destroy', $memberInstrument->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('memberInstruments.show', [$memberInstrument->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('memberInstruments.edit', [$memberInstrument->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>