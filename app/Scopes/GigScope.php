<?php

namespace App\Scopes;

use App\Models\Member;
use Auth;
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
		$request = \Request::getPathInfo();
		if (starts_with($request, '/admin/gig/')) return;

		$builder->join('artists as b', 'b.id', 'artist_id');

		$builder->whereRaw('gigs.deleted_at is null');

		$user = Auth::user();
		if ($user !== null)
		{
			$member = Member::where('user_id', $user->id)->first();
			$builder = $builder->join('artist_members', function ($join) use ($member)
			{
				$join->on('b.id', 'artist_members.artist_id')->where('member_id', $member->id);
			});
		}

		$builder
			->join('venues as v', 'v.id', 'venue_id')
			->join('dropdowns as dd', 'dd.id', 'age')
			->join('addresses as a', 'a.id', 'v.address_id')
			->join('streets as s', 's.id', 'a.street_id')
			->join('postalcodes as p', 'p.id', 'a.postalcode_id')
			->join('cities as c', 'c.id', 'p.city_id')
			->join('states as st', 'st.id', 'c.state_id')
			->join('countries as co', 'co.id', 'st.country_id')
			->join('timezones as t', 't.id', 'a.timezone_id')
			->select([
				'gigs.*',
				'b.name as artistName',
				'b.website as artistWebsite',
				'v.name as venueName',
				'v.website as venueWebSite',
				'v.venuetype_id as venuetype_id',
				'a.id as address_id',
				'a.street_number',
				'a.longitude as longitude',
				'a.latitude as latitude',
				's.name as streetName',
				'c.name as cityName',
				'st.name as stateName',
				'co.name as countryName',
				'co.sortname as countryCode',
				'dd.value as ageValue',
				't.name as timeZone',
				DB::raw("@address:=CONCAT(@street:=CONCAT(a.street_number,' ',s.name,' ',c.name,', ',st.name),', ',co.name) as address"),
				DB::raw("@house:=CONCAT(@street,', ',co.name) as house"),
				DB::raw("@info:=CONCAT(TRIM(LEADING '0' FROM REPLACE(DATE_FORMAT(start, '%h:%i%p %D %b'),':00','')),' - ',b.name,' at ',v.name, RTRIM(CONCAT(' ', IFNULL(price, '')))) as info")
			])->orderBy('start', 'desc');
	}
}