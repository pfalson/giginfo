<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Gig
 *
 * @package App
 * @version October 23, 2016, 7:57 pm UTC
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $artist_id
 * @property integer $venue_id
 * @property string $start
 * @property string $finish
 * @property string $description
 * @property mixed $poster
 * @property string $price
 * @property \App\Models\DropDowns $age
 * @property integer $type
 * @property string $name
 * @property string $ticketurl
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Models\Artist $artist
 * @property-read \App\Models\Venue $venue
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereArtistId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereVenueId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereFinish($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig wherePoster($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereAge($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereTicketurl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereDeletedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $venuetype
 * @property-read mixed $house
 * @property string $image
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereImage($value)
 * @property-read mixed $timezone
 * @property-read mixed $when
 * @property-read mixed $starttime
 * @property-read mixed $finishtime
 */
class Gig extends GigBase
{
	use CrudTrait;
	use SoftDeletes;

	public function getStartAttribute()
	{
		return $this->convertFromUTC('start');
	}

	public function getWhenAttribute()
	{
		return explode(' ', $this->start)[0];
	}

	public function getStarttimeAttribute()
	{
		return explode(' ', $this->start)[1];
	}

	public function getFinishtimeAttribute()
	{
		return explode(' ', $this->finish)[1];
	}

	public function getFinishAttribute()
	{
		return $this->convertFromUTC('finish');
	}

	public function withFakes($columns = [])
	{
		/** @noinspection PhpUndefinedMethodInspection */
		return Gig::where('gigs.id', $this->id)->details()->first();
	}

	/**
	 * @param \Eloquent $builder
	 * @return mixed
	 */
	public function scopeDetails($builder)
	{
		return $builder
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
				'v.name as venueName',
				'v.website as venueURI',
				'v.venuetype_id as venuetype_id',
				'a.id as address_id',
				'a.street_number',
				'a.longitude as longitude',
				'a.latitude as latitude',
				's.name as street',
				'c.name as city',
				'st.name as state',
				'p.code as postal_code',
				'co.name as country',
				'co.sortname as countryCode',
				'dd.value as ageValue',
				't.name as timeZone',
				DB::raw("@address:=CONCAT(@street:=CONCAT(a.street_number,' ',s.name,' ',c.name,', ',st.name),', ',co.name) as address"),
				DB::raw("@house:=CONCAT(@street,', ',co.name) as house")
			])->get();
	}
}
