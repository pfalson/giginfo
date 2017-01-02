<!-- Artist Id Field -->
<div class="form-group">
    {!! Form::label('artistName', 'Artist:') !!}
    {!! $gig->artistName !!}
</div>

<!-- Venue Id Field -->
<div class="form-group">
    {!! Form::label('venueName', 'Venue:') !!}
    <a href="{!! $gig->venueWebSite !!}">{!! $gig->venueName !!}</a>
</div>

<!-- Start Field -->
<div class="form-group">
    {!! Form::label('date', 'When:&nbsp;&nbsp;') !!}
    {!! date('dS M Y', strtotime($gig->start)) !!}
    {!! Form::label('from', '&nbsp;&nbsp;from&nbsp;&nbsp;') !!}
    {!! date('h:ia', strtotime($gig->start)) !!}
    {!! Form::label('to', '&nbsp;&nbsp;to&nbsp;&nbsp;') !!}
    {!! date('h:ia', strtotime($gig->finish)) !!}
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
        <img src="https://giginfo.org/gigs/{{ $gig->id }}/poster" style="width: 100px; height: 150px;" />
    </div>
@endif
<div><p></p></div>