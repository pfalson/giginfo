
<li class="{{ Request::is('gigs*') ? 'active' : '' }}">
xxx    <a href="{!! route('crud.gig.index') !!}"><i class="fa fa-edit"></i><span>Gigs</span></a>
</li>

<li class="{{ Request::is('artists*') ? 'active' : '' }}">
    <a href="{!! route('crud.artist.index') !!}"><i class="fa fa-edit"></i><span>Artists</span></a>
</li>

<li class="{{ Request::is('artists_templates*') ? 'active' : '' }}">
    <a href="{!! route('crud.artist_template.index') !!}"><i class="fa fa-edit"></i><span>Artist Templates</span></a>
</li>

<li class="{{ Request::is('artists_template_types*') ? 'active' : '' }}">
    <a href="{!! route('crud.artist_template_type.index') !!}"><i class="fa fa-edit"></i><span>Active Artist Templates</span></a>
</li>