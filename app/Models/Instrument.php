<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Instrument
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Instrument whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Instrument whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Instrument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Instrument whereDeletedAt($value)
 */
class Instrument extends Elegant {

	protected $table = 'instruments';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = array('name');
}