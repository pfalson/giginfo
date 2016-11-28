<?php
/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 10/28/2016
 * Time: 4:00 PM
 */

namespace App;


use App\Scopes\AgeScope;

/**
 * App\Age
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @property string $code
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\App\Age whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Age whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Age whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Age whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Age whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Age whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Age whereValue($value)
 * @mixin \Eloquent
 */
class Age extends Elegant
{
	protected $table      = 'dropdowns';
	public    $timestamps = true;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('code','value');

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope(new AgeScope());
	}
}