<div class="form-group has-feedback">
    <!-- Street Number Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('street_number', 'Street Number:') !!}
        {!! Form::text('street_number', null, ['class' => 'form-control']) !!}
    </div>

    {{ Form::hidden('street_id', Request::old('street_id'),array('id'=>'street_id'))}}
    <div class="form-group col-md-6">
        <label for="street">Street:</label>
        <input class="form-control" type="text" name="streetName" id="streetName"
               value="{{{ Request::old('streetName', isset($address) ? $address->streetName : null) }}}"/>
    </div>

    <!-- City Id Field -->
    <div class="form-group col-md-6">
        {!! Form::label('city_id', 'City:') !!}
        {{ Form::hidden('street_id', Request::old('street_id'),array('id'=>'street_id'))}}
        {!! Form::text('cityName', $value = old('cityName'), [
            'placeholder'   => 'Start Typing for Suggestions',
            'id'            => 'cityName',
            'class'         => 'form-control',
            'required'      => 'required'
            ]) !!}
        <i style="display: none;" class="form-control-feedback" data-bv-icon-for="cityName"></i>
    </div>

    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('addresses.index') !!}" class="btn btn-default">Cancel</a>
    </div>
