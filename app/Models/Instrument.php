<?php

namespace App\Models;

use App\Elegant;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Instrument
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Instrument whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Instrument whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Instrument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Instrument whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Instrument whereName($value)
 */
class Instrument extends Elegant
{

	protected $table      = 'instruments';
	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('name');
}