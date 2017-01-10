<?php

namespace App\Models;

use App\Elegant;
use App\Scopes\ArtistTemplateScope;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ArtistTemplate
 *
 * @package App
 * @version October 23, 2016, 7:57 pm UTC
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $artist_id
 * @property \App\Models\DropDowns $templatetype_id
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Models\Artist $artist
 * @property-read \App\Models\TemplateType $templatetype
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistTemplate whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistTemplate whereArtistId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistTemplate whereTemplateTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistTemplate whereDeletedAt($value)
 * @mixin \Eloquent
 */
class ArtistTemplate extends Elegant
{
	use CrudTrait;

	use SoftDeletes;

	public $table = 'artist_templates';

	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';

	protected $dates = ['deleted_at'];

	public $fillable = [
		'artist_id',
		'templatetype_id',
		'name',
		'source'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'id'              => 'integer',
		'artist_id'       => 'integer',
		'templatetype_id' => 'integer',
		'name'            => 'string',
		'source'          => 'text',
	];

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	public static function boot()
	{
		parent::boot();

		static::addGlobalScope(new ArtistTemplateScope());
	}

//	/**
//	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//	 **/
//	public function type()
//	{
//		return $this->belongsTo(DropDowns::class, 'templatetype', 'id')->where('name', 'templatetype');
//	}

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
	public function templatetype()
	{
		return $this->belongsTo(TemplateType::class);
	}
}