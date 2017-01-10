<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Gig
 *
 * @package App
 * @version October 23, 2016, 7:57 pm UTC
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $artist_id
 * @property integer $venue_id
 * @property string $start
 * @property string $finish
 * @property string $description
 * @property mixed $poster
 * @property string $price
 * @property \App\Models\DropDowns $age
 * @property integer $type
 * @property string $name
 * @property string $ticketurl
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Models\Artist $artist
 * @property-read \App\Models\Venue $venue
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereArtistId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereVenueId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereFinish($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig wherePoster($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereAge($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereTicketurl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereDeletedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $venuetype
 * @property-read mixed $house
 * @property string $image
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gig whereImage($value)
 * @property-read mixed $timezone
 */
class Gig extends GigBase
{
	use CrudTrait;

	use SoftDeletes;

	public function getStartAttribute()
	{
		return $this->convertFromUTC('start');
	}

	public function getWhenAttribute()
	{
		return explode(' ', $this->start)[0];
	}

	public function getStarttimeAttribute()
	{
		return explode(' ', $this->start)[1];
	}

	public function getFinishtimeAttribute()
	{
		return explode(' ', $this->finish)[1];
	}

	public function getFinishAttribute()
	{
		return $this->convertFromUTC('finish');
	}
}
