<!-- Member Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('member_id', 'Member Id:') !!}
    {!! Form::number('member_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Instrument Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('instrument_id', 'Instrument Id:') !!}
    {!! Form::number('instrument_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('memberInstruments.index') !!}" class="btn btn-default">Cancel</a>
</div>
