<?php

namespace App\Scopes;

use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 10/22/2016
 * Time: 10:20 AM
 */
class VenueScope implements Scope
{
	/**
	 * Apply the scope to a given Eloquent query builder.
	 * @param Builder $builder
	 * @param Model $model
	 */
	public function apply(Builder $builder, Model $model)
	{
		$builder
			->join('addresses as a', 'a.id', 'address_id')
			->join('streets as s','s.id','a.street_id')
			->join('postalcodes as p', 'p.id', 'a.postalcode_id')
			->join('cities as c', 'c.id', 'p.city_id')
			->join('states as st', 'st.id', 'c.state_id')
			->join('countries as co', 'co.id', 'st.country_id')
			->select([
				'venues.*',
				'a.street_number',
				'a.longitude',
				'a.latitude',
				'p.code as postal_code',
				's.name as street',
				'c.name as city',
				'st.name as state',
				'co.name as country',
				'co.sortname as sortname',
				DB::raw("CONCAT(street_number,' ',s.name,' ',c.name,', ',st.name,', ',co.sortname) as address"),
				DB::raw("CONCAT(venues.name,', ',street_number,' ',s.name,', ',c.name,', ',st.name,', ',co.sortname) as details")
			]);
	}
}