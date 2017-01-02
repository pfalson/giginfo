<!-- label field -->

<div @include('crud::inc.field_wrapper_attributes') >
<div class="label">
    <label
        @if (isset($field['attributes']))
    @foreach ($field['attributes'] as $attribute => $value)
    {{ $attribute }}="{{ $value }}"
    @endforeach
    @endif
    >
     {!! $field['label'] !!}
    </label>
</div>
</div>
