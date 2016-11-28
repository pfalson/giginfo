<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * App\City
 *
 * @property integer $id
 * @property string $name
 * @property integer $state_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\City whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\City whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\City whereStateId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\City whereDeletedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\City search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Query\Builder|\App\City searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 */
class City extends Elegant
{

	protected $table      = 'cities';
	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('name', 'state_id');

	use SearchableTrait;

	protected $searchable = [
		'columns' => [
			'cities.name' => 10,
		],
	];
}