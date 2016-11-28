<?php

namespace App\Models;

use App\Elegant;
use App\Scopes\ArtistScope;
use Backpack\CRUD\CrudTrait;

/**
 * App\Models\Artist
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $website
 * @property string $facebook
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereFacebook($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Gig[] $gigs
 */
class Artist extends Elegant
{

	protected $table      = 'artists';
	public    $timestamps = true;
	protected $fillable   = array('name', 'website', 'facebook');

	use CrudTrait;

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

	public function gigs()
	{
		return $this->belongsToMany(Gig::class);
	}
}