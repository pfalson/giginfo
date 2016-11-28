<?php

namespace App\Models;

use App\Elegant;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PostalLocation
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalLocation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalLocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalLocation whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PostalLocation whereName($value)
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