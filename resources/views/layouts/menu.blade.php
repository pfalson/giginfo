{{--<li class="{{ Request::is('venues*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('venues.index') !!}"><i class="fa fa-edit"></i><span>Venues</span></a>--}}
{{--</li>--}}

{{--<li class="{{ Request::is('streets*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('streets.index') !!}"><i class="fa fa-edit"></i><span>Streets</span></a>--}}
{{--</li>--}}

{{--<li class="{{ Request::is('addresses*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('addresses.index') !!}"><i class="fa fa-edit"></i><span>Addresses</span></a>--}}
{{--</li>--}}

<li class="{{ Request::is('gigs*') ? 'active' : '' }}">
    <a href="{!! route('crud.gig.index') !!}"><i class="fa fa-edit"></i><span>Gigs</span></a>
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