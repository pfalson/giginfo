<?php

namespace App\Models;

use App\Elegant;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ArtistMemberRole
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property integer $artist_id
 * @property integer $member_id
 * @property integer $role_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistMemberRole whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistMemberRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistMemberRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistMemberRole whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistMemberRole whereArtistId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistMemberRole whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistMemberRole whereRoleId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Artist $artist
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\ArtistRole $role
 */
class ArtistMemberRole extends Elegant
{

	protected $table      = 'artist_member_roles';
	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('artist_id', 'member_id', 'role_id');

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

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function role()
	{
		return $this->hasOne(ArtistRole::class);
	}
}