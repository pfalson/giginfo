<?php

namespace App\Models;

use App\Elegant;
use App\Scopes\TemplateTypeScope;
use Backpack\CRUD\CrudTrait;

/**
 * App\Models\TemplateType
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TemplateType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TemplateType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TemplateType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TemplateType whereName($value)
 * @mixin \Eloquent
 * @property \Carbon\Carbon $deleted_at
 * @property string $code
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TemplateType whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TemplateType whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TemplateType whereValue($value)
 */
class TemplateType extends Elegant
{
	use CrudTrait;

	protected $table      = 'dropdowns';
	public    $timestamps = true;

	protected $dates    = ['deleted_at'];
	protected $fillable = array('code', 'value');

	protected $attributes = ['name' => 'templatetype'];

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope(new TemplateTypeScope());
	}
}