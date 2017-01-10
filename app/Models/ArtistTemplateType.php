<?php

namespace App\Models;

use App\Elegant;
use App\Scopes\ArtistTemplateTypeScope;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ArtistTemplateType
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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistTemplateType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistTemplateType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistTemplateType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistTemplateType whereArtistId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistTemplateType whereTemplateTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistTemplateType whereDeletedAt($value)
 * @mixin \Eloquent
 */
class ArtistTemplateType extends Elegant
{
	use CrudTrait;

	use SoftDeletes;

	public $table = 'artist_template_types';

	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';

	protected $dates = ['deleted_at'];

	public $fillable = [
		'artist_id',
		'templatetype_id',
		'artist_template_id'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'id'                 => 'integer',
		'artist_id'          => 'integer',
		'templatetype_id'    => 'integer',
		'artist_template_id' => 'integer'
	];

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	public static function boot()
	{
		parent::boot();

		static::addGlobalScope(new ArtistTemplateTypeScope());
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function type()
	{
		return $this->belongsTo(DropDowns::class, 'templatetype', 'id')->where('name', 'templatetype');
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
	public function artistTemmplate()
	{
		return $this->belongsTo(ArtistTemplate::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function templatetype()
	{
		return $this->belongsTo(TemplateType::class);
	}
}