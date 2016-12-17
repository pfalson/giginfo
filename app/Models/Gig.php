<?php

namespace App\Models;

use App\Elegant;
use App\Scopes\GigScope;
use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;
use Exception;
use File;
use Illuminate\Database\Eloquent\SoftDeletes;
use Image;
use Log;
use Illuminate\Http\Request;
use Response;
use Storage;

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
		'ticketurl',
		'type'
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

	public function old_setPosterAttribute($value)
	{
		Log::error('setPosterAttribute');
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
				Log::error($e->getMessage());
				$value = null;
			}
		}

		$this->attributes[$attribute_name] = $value;
	}

	public function setPosterAttribute($value)
	{
		$attribute_name = "poster";
		$disk = "public";
		$destination_path = "uploads/artists/" . $this->artist_id;

		// if the image was erased
		if ($value == null)
		{
			// delete the image from disk
			Storage::disk($disk)->delete($this->image);

			// set null in the database column
			$this->attributes[$attribute_name] = null;
		}

// if a base64 was sent, store it in the db
		if (starts_with($value, 'data:image'))
		{
			// 0. Make the image
			$image = Image::make($value);
			// 1. Generate a filename.
			$filename = md5($value . time()) . '.jpg';
			// 2. Store the image on disk.
			$dir = public_path() . '/' . $destination_path;

			if (!File::exists($dir))
			{
				$result = File::makeDirectory($dir, 0777, true);
			}

			$image->save($dir . '/' . $filename);

			// 3. Save the path to the database
			$this->attributes[$attribute_name] = $destination_path . '/' . $filename;
		}
	}

	public function getShows(Request $request)
	{
		$artist_id = $request->input('artist');
		$when = $request->input('when');
		$builder = Gig::where(compact('artist_id'));

		$now = Carbon::now();
		$direction = 'asc';

		switch ($when)
		{
			case 'future':
				$builder = $builder->where('start', '>=', $now);
				break;
			case 'past':
				$builder = $builder->where('start', '<', $now);
				$direction = 'desc';
				break;
		}

		return $builder
			->select(
				'artists.name as artistName',
				'gigs.id',
				'gigs.name',
				'gigs.description',
				'gigs.start',
				'gigs.poster',
				'venues.name as venueName',
				'venues.website as venueURI',
				'addresses.street_number',
				'streets.name as streetName',
				'cities.name as cityName',
				'states.abbr',
				'countries.sortname as countryCode',
				'ageValue'
			)->orderBy('start', $direction)
			->get();
	}
}
