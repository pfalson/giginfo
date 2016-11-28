<!-- City Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('city_id', 'City Id:') !!}
    {!! Form::number('city_id', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group has-feedback">
    <div class="col-lg-8">
        {!! Form::text('city', $value = old('city'), [
            'placeholder'   => 'Start Typing for Suggestions',
            'id'            => 'city',
            'class'         => 'form-control',
            'required'      => 'required',
            'autofocus'     => 'autofocus'
            ]) !!}
        <i style="display: none;" class="form-control-feedback" data-bv-icon-for="city"></i>
    </div>
</div>
<!-- Street Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('street_number', 'Street Number:') !!}
    {!! Form::text('street_number', null, ['class' => 'form-control']) !!}
</div>

{{--<!-- Street Id Field -->--}}
{{--<div class="form-group col-sm-6">--}}
{{--{!! Form::label('street_id', 'Street Id:') !!}--}}
{{--{!! Form::text('street_id', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{ Form::hidden('street_id', Request::old('street_id'),array('id'=>'street_id'))}}
<div class="col-md-6">
    <div class="form-group">
        <label class="col-md-4 control-label" for="street">Street :</label>
        <div class="col-md-8">
            <input class="form-control" type="text" name="street" id="street" value="{{{ Request::old('street', isset($address) ? $address->street_id : null) }}}" />
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('addresses.index') !!}" class="btn btn-default">Cancel</a>
</div>
