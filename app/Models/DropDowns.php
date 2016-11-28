<?php

namespace App\Models;

use App\Elegant;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\DropDowns
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @property string $code
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DropDowns whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DropDowns whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DropDowns whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DropDowns whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DropDowns whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DropDowns whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DropDowns whereValue($value)
 * @mixin \Eloquent
 */
class DropDowns extends Elegant {

	protected $table = 'dropdowns';
	public $timestamps = true;

	use CrudTrait;
	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = array('name', 'code', 'value');

}