<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Country
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $sortname
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Country whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Country whereSortname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Country whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Country whereDeletedAt($value)
 */
class Country extends Elegant {

	protected $table = 'countries';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = array('sortname', 'name');
}