<?php

namespace App\Models;

use App\Elegant;
use App\Scopes\GigScope;
use Backpack\CRUD\CrudTrait;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Image;
use Log;
use Response;

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
 */
class Gig extends Elegant
{
	use CrudTrait;

	use SoftDeletes;

	public $table = 'gigs';

	public $age;

	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';


	protected $dates = ['deleted_at'];


	public $fillable = [
		'artist_id',
		'venue_id',
		'start',
		'finish',
		'description',
		'poster',
		'price',
		'age',
		'name',
		'ticketurl'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'id'          => 'integer',
		'artist_id'   => 'integer',
		'venue_id'    => 'integer',
		'description' => 'string',
		'poster'      => 'string',
		'price'       => 'string',
		'age'         => 'integer',
		'type'        => 'integer',
		'name'        => 'string',
		'ticketurl'   => 'string'
	];

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public static $rules = [
		'artist_id' => 'required|exists:artists,id',
		'venue_id'  => 'required|exists:venues,id'
	];

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	public static function boot()
	{
		parent::boot();

		static::addGlobalScope(new GigScope());
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function age()
	{
		return $this->belongsTo(DropDowns::class, 'age', 'id')->where('name', 'age');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function artist()
	{
		return $this->belongsTo(Artist::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function venue()
	{
		return $this->belongsTo(Venue::class);
	}

	public function getVenuetypeAttribute()
	{
		return $this->venue->venuetype_id;
	}

	public function getHouseAttribute()
	{
		return $this->venue->details;
	}

	public function setPosterAttribute($value)
	{
		$attribute_name = "poster";

		// if the image was erased
		if ($value !== null)
		{
			try
			{
				$img = Image::make($value);
				Response::make($img->encode('jpeg'));
				$value = $img->getEncoded();
			} catch (Exception $e)
			{
				Log::alert($e->getMessage());
				$value = null;
			}
		}

		$this->attributes[$attribute_name] = $value;
	}
}
