<?php
/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 1/7/2017
 * Time: 1:55 PM
 */

namespace App\Models;
use App\Elegant;


/**
 * App\Models\UserInfo
 *
 * @property integer $user_id
 * @property string $biography
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereBiography($value)
 * @mixin \Eloquent
 */
class UserInfo extends Elegant
{
	protected $table      = 'userinfos';
	protected $fillable = array('biography');

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
//	public static function boot()
//	{
//		parent::boot();
//
//		static::addGlobalScope(new ArtistScope());
//	}

}