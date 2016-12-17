<?php
/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 10/28/2016
 * Time: 4:00 PM
 */

namespace App\Models;


use App\Elegant;
use App\Scopes\ArtistRoleScope;

/**
 * App\Models\ArtistRole
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @property string $code
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistRole whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistRole whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistRole whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistRole whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistRole whereValue($value)
 * @mixin \Eloquent
 */
class ArtistRole extends Elegant
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

		static::addGlobalScope(new ArtistRoleScope());
	}
}