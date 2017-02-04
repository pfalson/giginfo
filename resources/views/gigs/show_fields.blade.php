<!-- Artist Id Field -->
<div class="form-group">
    {!! Form::label('artistName', 'Artist:') !!}
    @if ($gig->artistWebsite)
        <a href="{!! $gig->artistWebsite !!}">{!! $gig->artistName !!}</a>
    @else
        {!! $gig->artistName !!}
    @endif
</div>

<!-- Venue Id Field -->
<div class="form-group">
    @if (!empty($gig->venueName))
        {!! Form::label('venueName', 'Venue:') !!}
        <a href="{!! $gig->venueURI !!}">{!! $gig->venueName !!}</a>
    @else
        {!! Form::label('address', 'Address:') !!}
        {!! $gig->address !!}
    @endif
</div>

@if (!empty($gig->ticketurl))
    <div class="form-group">
        {!! Form::label('ticketurl', 'Tickets:') !!}
        <a href="{!! $gig->ticketurl !!}"></a>
    </div>
@endif

<!-- Start Field -->
<div class="form-group">
    {!! Form::label('date', 'When:&nbsp;&nbsp;') !!}
    {!! date('dS M Y', strtotime($gig->start)) !!}
    {!! Form::label('from', '&nbsp;&nbsp;from&nbsp;&nbsp;') !!}
    {!! date('g:ia', strtotime($gig->start)) !!}
    {!! Form::label('to', '&nbsp;&nbsp;to&nbsp;&nbsp;') !!}
    {!! date('g:ia', strtotime($gig->finish)) !!}
</div>


<!-- Price Field -->
<div class="form-group inline">
    {!! Form::label('price', $gig->price ? 'Price:' : 'No cover') !!}
    {!! $gig->price !!}
</div>

<!-- Age Field -->
<div class="form-group inline" style="margin-left: 10px;">
    {!! Form::label('age', 'Age:') !!}
    {!! $gig->ageValue !!}
</div>

<!-- Name Field -->
@if ($gig->name)
    <p></p>
    <div class="form-group" style="font-style: italic">
        {!! $gig->name !!}
    </div>
@endif

<!-- Description Field -->
@if ($gig->description)
    <div class="form-group">
        {!! $gig->description !!}
    </div>
@endif

<!-- Poster Field -->
@if ($gig->poster)
    <div class="form-group">
        <img src="/gigs/{{ $gig->id }}/poster" style="width: 100px; height: 150px;" />
    </div>
@endif
<div><p></p></div>