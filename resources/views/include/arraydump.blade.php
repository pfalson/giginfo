<table>
    @foreach($array as $key => $value)
        <tr>
            <td><strong>{{ $key }}</strong></td>
            @if (is_array($value))
                @include('include.arraydump', ['array' => $value])
            @else
                <td>{!! $value !!}</td>
            @endif
        </tr>
    @endforeach
</table>