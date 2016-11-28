<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ArtistMember
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property integer $artist_id
 * @property integer $member_id
 * @method static \Illuminate\Database\Query\Builder|\App\ArtistMember whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArtistMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArtistMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArtistMember whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArtistMember whereArtistId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArtistMember whereMemberId($value)
 * @mixin \Eloquent
 */
class ArtistMember extends Elegant {

	protected $table = 'artist_members';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = array('artist_id', 'member_id');

}