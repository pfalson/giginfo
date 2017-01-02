<!-- heading field -->
<div @include('crud::inc.field_wrapper_attributes') >
    <div class="heading">
        <hr style="margin: 0;">
        <h4>{!! $field['label'] !!}</h4>
        @if (isset($field['value']))
            <div class="panel-body">
                {!! $field['value'] !!}
            </div>
        @endif
    </div>
</div>
