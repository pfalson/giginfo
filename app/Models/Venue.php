<?php

namespace App;

use App\Scopes\VenueScope;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property-read \App\Address $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Gig[] $gigs
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereDeletedAt($value)
 * @mixin \Eloquent
 */

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
 * @property-read \App\Address $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Gig[] $gigs
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venue whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Venue extends Elegant
{
    use SoftDeletes;

    public $table = 'venues';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
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
        'id' => 'integer',
        'name' => 'string',
        'website' => 'string',
        'facebook' => 'string',
        'address_id' => 'integer',
        'phone' => 'string'
    ];

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope(new VenueScope());
	}

	/**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function address()
    {
        return $this->belongsTo(\App\Address::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function gigs()
    {
        return $this->hasMany(\App\Gig::class);
    }
}