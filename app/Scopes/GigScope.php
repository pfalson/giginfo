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
class GigScope implements Scope
{
	/**
	 * Apply the scope to a given Eloquent query builder.
	 * @param Builder $builder
	 * @param Model $model
	 */
	public function apply(Builder $builder, Model $model)
	{
		$builder
			->join('venues as v', 'v.id', 'venue_id')
			->join('dropdowns as dd', 'dd.id', 'age')
			->join('artists as b', 'b.id', 'artist_id')
			->join('addresses as a', 'a.id', 'v.address_id')
			->join('streets as s','s.id','a.street_id')
			->join('postalcodes as p', 'p.id', 'a.postalcode_id')
			->join('cities as c', 'c.id', 'p.city_id')
			->join('states as st', 'st.id', 'c.state_id')
			->join('countries as co', 'co.id', 'st.country_id')
			->select([
				'gigs.*',
				'b.name as artistName',
				'v.name as venueName',
				'a.street_number',
				's.name as streetName',
				'c.name as cityName',
				'st.name as stateName',
				'co.name as countryName',
				'co.sortname as countryCode',
				'dd.value as ageValue',
				DB::raw("CONCAT(a.street_number,' ',s.name,' ',c.name,', ',st.name,', ',co.sortname) as address"),
				DB::raw("CONCAT(street_number,' ',s.name,', ',c.name,', ',st.name,', ',co.name) as house")
			]);
	}
}