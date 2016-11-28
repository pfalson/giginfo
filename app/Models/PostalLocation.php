<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\PostalLocation
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\PostalLocation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalLocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalLocation whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostalLocation whereName($value)
 * @mixin \Eloquent
 */
class PostalLocation extends Elegant
{

	protected $table      = 'postallocations';
	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('name');

}