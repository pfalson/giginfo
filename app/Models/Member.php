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
 * @property string $name
 * @property boolean $primary_role
 * @property string $biography
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member wherePrimaryRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member whereBiography($value)
 * @mixin \Eloquent
 */
class Member extends Elegant {

	protected $table = 'members';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $fillable = ['name', 'primary_role', 'biography'];
}