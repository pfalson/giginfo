<?php

namespace App\Models;

use App\Elegant;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Street
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Street whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Street whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Street whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Street whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Street whereName($value)
 * @mixin \Eloquent
 * @property-read \App\Models\City $city
 */
class Street extends Elegant
{

	protected $table      = 'streets';
	public    $timestamps = true;

	use CrudTrait;
	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('name');

	public function city()
	{
		return $this->belongsTo(City::class);
	}
}