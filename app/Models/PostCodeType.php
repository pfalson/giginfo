<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\PostCodeType
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\PostCodeType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostCodeType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostCodeType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostCodeType whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostCodeType whereName($value)
 * @mixin \Eloquent
 */
class PostCodeType extends Elegant
{

	protected $table      = 'postcodetypes';
	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('name');

}