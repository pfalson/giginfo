<?php

namespace App\Models;

use App\Elegant;
use App\Scopes\ArtistScope;
use Auth;
use Backpack\CRUD\CrudTrait;
use DB;

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
 * @property integer $city_id
 * @property-read \App\Models\City $city
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereCityId($value)
 * @property string $description
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Genre[] $genres
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Artist details()
 */
class Artist extends Elegant
{

	protected $table      = 'artists';
	public    $timestamps = true;
	protected $fillable   = array('name', 'description', 'city_id', 'website', 'facebook');

	use CrudTrait;

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	public static function boot()
	{
		parent::boot();

//		static::addGlobalScope(new ArtistScope());
	}

	public function city()
	{
		return $this->hasOne(City::class);
	}

	public function genres()
	{
		return $this->belongsToMany(Genre::class);
	}

	public function gigs()
	{
		return $this->belongsToMany(Gig::class);
	}

	/**
	 * @param array $options
	 * @return bool
	 */
	public function save(array $options = [])
	{
		// TODO update xref
		$item = parent::save($options);

		return $item;
	}

	/**
	 * @param array $attributes
	 * @return bool|Elegant
	 */
	public static function create(array $attributes = [])
	{
		$committed = false;

		DB::beginTransaction();

		$item = parent::create($attributes);

		if ($item)
		{
			$user = Auth::user();
			$member = Member::whereUserId($user->id)->first();

			$artistMember = ArtistMember::create(['artist_id' => $item->id, 'member_id' => $member->id]);

			if ($artistMember)
			{
				$role = ArtistRole::whereCode('a')->first();

				$artistMemberRole = ArtistMemberRole::create(['artist_id' => $item->id, 'member_id' => $member->id, 'role_id' => $role->id]);

				if ($artistMemberRole)
				{
					$committed = true;
					DB::commit();
				}
			}
		}

		if (!$committed)
		{
			DB::rollBack();
		}

		return $item;
	}

	public function scopeDetails($builder)
	{
		$user = Auth::user();
		if ($user !== null)
		{
			$member = Member::where('user_id', $user->id)->first();
			$builder = $builder->join('artist_members', function($join) use($member)
			{
				$join->on('artists.id', 'artist_id')->where('member_id', $member->id);
			});
		}

		$builder->select()
			->join('cities as c', 'c.id', 'city_id')
			->join('states as st', 'st.id', 'c.state_id')
//			->join('postalcodes as p', 'p.city_id', 'artists.city_id')
			->join('countries as co', 'co.id', 'st.country_id')
			->select([
				'artists.*',
//				'p.longitude',
//				'p.latitude',
//				'p.code as postal_code',
				'c.name as city',
				'st.name as state',
				'co.name as country',
				'co.sortname as sortname',
				DB::raw("CONCAT(c.name,', ',st.name,', ',co.sortname) as location")
			]);
	}
}