<?php

namespace App\Models;
use App\Elegant;

/**
 * App\Models\Genre
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genre whereName($value)
 * @mixin \Eloquent
 */
class Genre extends Elegant {

	protected $table = 'genres';
	public $timestamps = true;
	protected $fillable = array('name');

}