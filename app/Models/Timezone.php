<?php

namespace App\Models;

use App\Elegant;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Timezone
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property string $zone
 * @property int $offset
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Timezone whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Timezone whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Timezone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Timezone whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Timezone whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Timezone whereZone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Timezone whereOffset($value)
 */
class Timezone extends Elegant
{

	protected $table      = 'timezones';
	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('name', 'zone', 'offset');
}