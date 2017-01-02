<?php

namespace App\Models;

use App\Elegant;
use App\Repositories\AddressRepository;
use App\Scopes\AddressScope;
use Backpack\CRUD\CrudTrait;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Address
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property integer $city_id
 * @property string $street_number
 * @property integer $street_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereStreetNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereStreetId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Street $street
 * @property-read \App\Models\City $city
 * @property float $longitude
 * @property float $latitude
 * @property integer $postalcode_id
 * @property integer $timezone_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address wherePostalcodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereTimezoneId($value)
 * @property-read \App\Models\PostalCode $postalcode
 * @property-read \App\Models\Timezone $timezone
 */
class Address extends Elegant
{

	protected $table      = 'addresses';
	public    $timestamps = true;

	use CrudTrait;
	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('street_number', 'street_id', 'longitude', 'latitude', 'postalcode_id', 'timezone_id');

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope(new AddressScope());
	}

	/**
	 * @param array $attributes
	 * @return array
	 */
	protected static function setTimeZone(array $attributes):array
	{
		$timezone = AddressRepository::createTimeZone($attributes['longitude'], $attributes['latitude']);
		$attributes['timezone_id'] = $timezone->id;
		return $attributes;
	}

	public function street()
	{
		return $this->belongsTo(Street::class);
	}

	public function postalcode()
	{
		return $this->belongsTo(PostalCode::class);
	}

	public function timezone()
	{
		return $this->belongsTo(Timezone::class);
	}

	/**
	 * @param array $options
	 * @return bool
	 */
	public function save(array $options = [])
	{
		$attributes = self::setTimeZone($this->getAttributes());
		$this->setRawAttributes($attributes);

		// TODO update xref
		$item = parent::save($options);

		return $item;
	}

	/**
	 * @param array $attributes
	 * @return bool|Elegant
	 */
	public static function create(array $attributes = [])
	{
		DB::beginTransaction();

		$attributes = self::setTimeZone($attributes);

		$item = parent::create($attributes);

		if ($item)
		{
			DB::commit();
		}
		else
		{
			DB::rollBack();
		}

		return $item;
	}
}