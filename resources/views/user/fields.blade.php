<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Biography Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('biography', 'Biography:') !!}
    {!! Form::textarea('biography', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('home') !!}" class="btn btn-default">Cancel</a>
</div>
