<?php

namespace App\Models;

use App\Elegant;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\State
 *
 * @property integer $id
 * @property string $name
 * @property integer $country_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $abbr
 * @method static \Illuminate\Database\Query\Builder|\App\Models\State whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\State whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\State whereCountryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\State whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\State whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\State whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\State whereAbbr($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 */
class State extends Elegant
{

	protected $table      = 'states';
	public    $timestamps = true;

	use CrudTrait;
	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('country_id', 'name');

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public function cities()
	{
		return $this->hasMany(City::class);
	}
}