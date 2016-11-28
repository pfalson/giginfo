<?php

namespace App\Models;

use App\Elegant;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * App\Models\City
 *
 * @property integer $id
 * @property string $name
 * @property integer $state_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereStateId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereDeletedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @property-read \App\Models\State $state
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Street[] $streets
 */
class City extends Elegant
{

	protected $table      = 'cities';
	public    $timestamps = true;

	use CrudTrait;
	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('name', 'state_id');

	use SearchableTrait;

	protected $searchable = [
		'columns' => [
			'cities.name' => 10,
		],
	];

	public function state()
	{
		return $this->belongsTo(State::class);
	}

	public function streets()
	{
		return $this->hasMany(Street::class);
	}
}