<?php

namespace App;

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
 * @property string $longtitude
 * @property string $latitude
 * @property integer $locationtype_id
 * @property integer $postcodetype_id
 * @method static \Illuminate\Database\Query\Builder|\App\PostalCode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalCode whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalCode whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalCode whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalCode wherePostallocationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalCode whereLongtitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalCode whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalCode whereLocationtypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalCode wherePostcodetypeId($value)
 * @mixin \Eloquent
 */
class PostalCode extends Elegant
{

	protected $table      = 'postalcodes';
	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('code', 'postallocation_id', 'longtitude', 'latitude', 'locationtype_id', 'postcodetype_id', 'city_id');

}