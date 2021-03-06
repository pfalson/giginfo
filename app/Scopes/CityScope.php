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
class CityScope implements Scope
{
	/**
	 * Apply the scope to a given Eloquent query builder.
	 * @param Builder $builder
	 * @param Model $model
	 */
	public function apply(Builder $builder, Model $model)
	{
		$builder->join('states as s','s.id','state_id')
			->select([
				'cities.*',
				's.name as stateName',
				DB::raw("CONCAT(cities.name,', ',s.name) as full_location"),
			]);
	}
}