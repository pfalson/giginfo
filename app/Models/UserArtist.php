<?php
/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 1/7/2017
 * Time: 1:55 PM
 */

namespace App\Models;


use App\Scopes\ArtistScope;

class UserArtist extends Artist
{
	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	public static function boot()
	{
		parent::boot();

		static::addGlobalScope(new ArtistScope());
	}

}