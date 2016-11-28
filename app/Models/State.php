<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\State
 *
 * @property integer $id
 * @property string $name
 * @property integer $country_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $abbr
 * @method static \Illuminate\Database\Query\Builder|\App\State whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\State whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\State whereCountryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\State whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\State whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\State whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\State whereAbbr($value)
 * @mixin \Eloquent
 */
class State extends Elegant
{

	protected $table      = 'states';
	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('country_id', 'name');

}