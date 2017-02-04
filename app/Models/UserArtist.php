<?php
/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 1/7/2017
 * Time: 1:55 PM
 */

namespace App\Models;


use App\Scopes\ArtistScope;

/**
 * App\Models\UserArtist
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $description
 * @property string $website
 * @property string $facebook
 * @property integer $city_id
 * @property-read \App\Models\City $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Genre[] $genres
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Gig[] $gigs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserArtist whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserArtist whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserArtist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserArtist whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserArtist whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserArtist whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserArtist whereFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserArtist whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist details()
 * @mixin \Eloquent
 */
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