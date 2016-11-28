<?php

namespace App\Models;

use App\Elegant;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Country
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $sortname
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereSortname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereDeletedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\State[] $states
 */
class Country extends Elegant
{

	protected $table      = 'countries';
	public    $timestamps = true;

	use CrudTrait;
	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('sortname', 'name');

	public function states()
	{
		return $this->hasMany(State::class);
	}
}