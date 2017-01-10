<style>
    tr.hover {
        cursor: hand;
        /* whatever other hover styles you want */
    }

    table#gigs-table {
        border-collapse: collapse;
    }

    #gigs-table tr {
        background-color: #eee;
        border-top: 1px solid #fff;
    }

    #gigs-table tr:hover {
        background-color: #ccc;
    }

    #gigs-table th {
        background-color: #fff;
    }

    #gigs-table th, #gigs-table td {
        padding: 3px 5px;
    }

    #gigs-table td:hover {
        cursor: pointer;
    }
</style>
<table id="gigs-table">
    <thead>
    <th></th>
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
    <?php
    $editLink = $link = 'gigs/%s';
    $editWord = $word = 'View';
    $artists = [];
    if (!Auth::guest())
    {
        $user = Auth::user();
        if ($user !== null)
        {
            $member = App\Models\Member::with('artist')->first();
            $artists = $member->artist->pluck('id')->toArray();
            $editLink = 'admin/gig/%s/edit';
            $editWord = 'Edit';
        }
    }
    ?>
    @foreach($gigs as $gig)
        <tr>
            <td>
                <a href="{{ sprintf($link, $gig->id) }}">{{ $word }}</a>
                @if (array_search($gig->artist_id, $artists) !== false)
                    <a href="{{ sprintf($editLink, $gig->id) }}">{{ $editWord }}</a>
                @endif
            </td>
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
<script>
    //    $(document).ready(function() {

    $('#gigs-table tr').click(function () {
        var href = $(this).find("a").attr("href");
        if (href) {
            window.location = href;
        }
    });
    //    });
</script>