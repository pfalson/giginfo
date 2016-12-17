<?php

namespace App\Models;

use App\Elegant;
use App\Scopes\VenueScope;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class Venue
 *
 * @package App
 * @version October 13, 2016, 2:07 am UTC
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $website
 * @property string $facebook
 * @property integer $address_id
 * @property string $phone
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Models\Address $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Gig[] $gigs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Venue whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Venue whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Venue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Venue whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Venue whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Venue whereFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Venue whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Venue wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Venue whereDeletedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property integer $venuetype_id
 * @property-read \App\Models\VenueType $venuetype
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Venue whereVenuetypeId($value)
 */
class Venue extends Elegant
{
	use CrudTrait;
	use SoftDeletes;
	use RevisionableTrait;

	public $table = 'venues';

	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';


	protected $dates = ['deleted_at'];
	protected $appends = ['details'];

	public $fillable = [
		'name',
		'venuetype_id',
		'website',
		'facebook',
		'address_id',
		'phone'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'id'         => 'integer',
		'name'       => 'string',
		'website'    => 'string',
		'facebook'   => 'string',
		'address_id' => 'integer',
		'phone'      => 'string'
	];

	public static $_rules = [
		'name' => 'required|unique:venues,name,@id'
	];

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	public static function boot()
	{
		parent::boot();

		static::addGlobalScope(new VenueScope());
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function venuetype()
	{
		return $this->belongsTo(VenueType::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function address()
	{
		return $this->belongsTo(Address::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 **/
	public function gigs()
	{
		return $this->hasMany(Gig::class);
	}
}