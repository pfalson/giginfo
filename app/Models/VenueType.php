<?php

namespace App\Models;

use App\Elegant;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\VenueType
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VenueType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VenueType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VenueType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VenueType whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VenueType whereName($value)
 * @mixin \Eloquent
 */
class VenueType extends Elegant {

	protected $table = 'venuetypes';
	public $timestamps = true;

	use CrudTrait;
	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = array('name');

}