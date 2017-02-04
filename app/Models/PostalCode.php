<?php

namespace App\Models;

use App\Elegant;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\PostalCode
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $code
 * @property integer $city_id
 * @property integer $postallocation_id
 * @property string $longitude
 * @property string $latitude
 * @property integer $locationtype_id
 * @property integer $postcodetype_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalCode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalCode whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalCode whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalCode whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalCode wherePostallocationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalCode whereLongtitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalCode whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalCode whereLocationtypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalCode wherePostcodetypeId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalCode whereLongitude($value)
 * @property-read \App\Models\City $city
 */
class PostalCode extends Elegant
{

	protected $table      = 'postalcodes';
	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('code', 'postallocation_id', 'longitude', 'latitude', 'locationtype_id', 'postcodetype_id', 'city_id');

	public function city()
	{
		return $this->belongsTo(City::class);
	}
}