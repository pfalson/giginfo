<li class="{{ Request::is('venues*') ? 'active' : '' }}">
    <a href="{!! route('venues.index') !!}"><i class="fa fa-edit"></i><span>Venues</span></a>
</li>

<li class="{{ Request::is('streets*') ? 'active' : '' }}">
    <a href="{!! route('streets.index') !!}"><i class="fa fa-edit"></i><span>Streets</span></a>
</li>

<li class="{{ Request::is('addresses*') ? 'active' : '' }}">
    <a href="{!! route('addresses.index') !!}"><i class="fa fa-edit"></i><span>Addresses</span></a>
</li>

