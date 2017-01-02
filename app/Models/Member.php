<?php

namespace App\Models;

use App\Elegant;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Member
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property integer $user_id
 * @property boolean $primary_role
 * @property string $biography
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member wherePrimaryRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member whereBiography($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artist[] $artist
 */
class Member extends Elegant {

	protected $table = 'members';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $fillable = ['user_id', 'primary_role', 'biography'];

	public function artist()
	{
		return $this->belongsToMany(Artist::class, 'artist_members');
	}
}