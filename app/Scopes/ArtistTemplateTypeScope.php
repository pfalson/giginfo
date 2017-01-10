<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 10/22/2016
 * Time: 10:20 AM
 */
class ArtistTemplateTypeScope implements Scope
{
	/**
	 * Apply the scope to a given Eloquent query builder.
	 * @param Builder $builder
	 * @param Model $model
	 */
	public function apply(Builder $builder, Model $model)
	{
		$request = \Request::getPathInfo();
		if (starts_with($request, '/admin/artist_template_type/')) return;

		$builder->join('artists as a', 'a.id', 'artist_id')
			->join('dropdowns as dd', 'dd.id', 'templatetype_id')
			->join('artist_templates as at', 'at.id', 'artist_template_id')
		;

		$builder->whereRaw('artist_template_types.deleted_at is null');

		$builder
			->select([
				'artist_template_types.*',
				'a.name as artistName',
				'a.website as artistWebsite',
				'dd.value as templateName',
				'at.name as artistTemplateName',
				'at.source as source'
			])->orderBy('artistName', 'asc');
	}
}