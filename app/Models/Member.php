<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Member
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @property boolean $primary_role
 * @property string $biography
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member wherePrimaryRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member whereBiography($value)
 * @mixin \Eloquent
 */
class Member extends Elegant {

	protected $table = 'members';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];

}