{!! '<'.'?'.'xml version="1.0" encoding="UTF-8" ?>' !!}
<feed xmlns="https://www.w3.org/2005/Atom"<?php foreach($namespaces as $n) echo " ".$n; ?>>
    <title type="text">{!! $channel['title'] !!}</title>
    <subtitle type="html"><![CDATA[{!! $channel['description'] !!}]]></subtitle>
    <link href="{{ Request::url() }}"></link>
    <id>{{ $channel['link'] }}</id>
    <link rel="alternate" type="text/html" href="{{ Request::url() }}" ></link>
    <link rel="self" type="application/atom+xml" href="{{ $channel['link'] }}" ></link>
@if (!empty($channel['logo']))
    <logo>{{ $channel['logo'] }}</logo>
@endif
@if (!empty($channel['icon']))
    <icon>{{ $channel['icon'] }}</icon>
@endif
        <updated>{{ $channel['pubdate'] }}</updated>
@foreach($items as $item)
    <?php
        $show = $item['content'];
            $hasPoster = empty($show['poster']) ? '0' : '1';
        ?>
        <show>
            <id>{{ $show['id'] }}</id>
            <poster>{{ $hasPoster }}</poster>
            <date>{{ explode(' ', $show['start'])[0] }}</date>
            <timeSet>{{ explode(' ', $show['start'])[1] }}</timeSet>
            <venueAddress>{{ $show['street_number'] . ' ' . $show['streetName'] . ' ' . $show['cityName'] }}</venueAddress>
            <stateAbbreviation>{{ $show['abbr'] }}</stateAbbreviation>
            <countryAbbreviation>{{ $show['countryCode'] }}</countryAbbreviation>
            <name>{{ $show['name'] }}</name>
            <city>{{ $show['cityName'] }}</city>
            <ageValue>{{ $show['ageValue'] }}</ageValue>
            <venueName>{{ $show['venueName'] }}</venueName>
            <venueURI>{{ $show['venueURI'] }}</venueURI>
            <recordKey>{{ $show['name'] }}</recordKey>
        </show>
@endforeach
</feed>
