<?php

namespace App;

use App\Scopes\AddressScope;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Address
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property integer $city_id
 * @property string $street_number
 * @property integer $street_id
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereStreetNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereStreetId($value)
 * @mixin \Eloquent
 */
class Address extends Elegant
{

	protected $table      = 'addresses';
	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('street_number', 'street_id', 'city_id');

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
}