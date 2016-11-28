<?php

namespace App\Models\Facades;

use Illuminate\Support\Facades\Facade;

class GigFacade extends Facade
{

	protected static function getFacadeAccessor()
	{
		return 'Gig';
	}
}
