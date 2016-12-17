<table class="table table-responsive" id="gigs-table">
    <thead>
    <th>Artist</th>
    <th>Venue</th>
    <th>Date</th>
    <th>Start</th>
    <th>Finish</th>
    <th>Price</th>
    <th>Age</th>
    <th>Name</th>
    </thead>
    <tbody>
    @foreach($gigs as $gig)
        <tr>
            <td>{!! $gig->artistName !!}</td>
            <td>{!! $gig->venueName !!}</td>
            <td>{!! date('d M Y', strtotime($gig->start)) !!}</td>
            <td>{!! date('h:ia', strtotime($gig->start)) !!}</td>
            <td>{!! date('h:ia', strtotime($gig->finish)) !!}</td>
            <td>{!! $gig->price !!}</td>
            <td>{!! $gig->ageValue !!}</td>
            <td>{!! $gig->name !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>