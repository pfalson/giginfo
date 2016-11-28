<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Street
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Street whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Street whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Street whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Street whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Street whereName($value)
 * @mixin \Eloquent
 */
class Street extends Elegant
{

	protected $table      = 'streets';
	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('name');

}