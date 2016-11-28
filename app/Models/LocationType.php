<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\LocationType
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\LocationType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LocationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LocationType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LocationType whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LocationType whereName($value)
 * @mixin \Eloquent
 */
class LocationType extends Elegant
{

	protected $table      = 'locationtypes';
	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('name');

}