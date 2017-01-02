<?php

namespace App\Models;

use App\Elegant;
use App\Scopes\GenreScope;
use Backpack\CRUD\CrudTrait;

/**
 * App\Models\Genre
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereName($value)
 * @mixin \Eloquent
 * @property \Carbon\Carbon $deleted_at
 * @property string $code
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereValue($value)
 */
class Genre extends Elegant
{
	use CrudTrait;

	protected $table      = 'dropdowns';
	public    $timestamps = true;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('code', 'value');

	protected $attributes = ['name' => 'genre'];

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope(new GenreScope());
	}
}