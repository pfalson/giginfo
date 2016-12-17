<?php

namespace App\Models;

use App\Elegant;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ArtistMember
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property integer $artist_id
 * @property integer $member_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistMember whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistMember whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistMember whereArtistId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistMember whereMemberId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Artist $artist
 * @property-read \App\Models\Member $member
 */
class ArtistMember extends Elegant {

	protected $table = 'artist_members';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = array('artist_id', 'member_id');

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function artist()
	{
		return $this->hasOne(Artist::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function member()
	{
		return $this->hasOne(Member::class);
	}
}