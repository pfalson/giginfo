<?php

namespace App;

/**
 * App\Artist
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $website
 * @property string $facebook
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereFacebook($value)
 * @mixin \Eloquent
 */
class Artist extends Elegant {

	protected $table = 'artists';
	public $timestamps = true;
	protected $fillable = array('name', 'website', 'facebook');

}