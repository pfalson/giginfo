<?php

namespace App\Models;

use App\Elegant;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ArtistGenre
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property integer $artist_id
 * @property integer $genre_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistGenre whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistGenre whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistGenre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistGenre whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistGenre whereArtistId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistGenre whereGenreId($value)
 * @mixin \Eloquent
 */
class ArtistGenre extends Elegant {

	protected $table = 'artist_genres';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = array('artist_id', 'genre_id');

}