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
class ArtistTemplateScope implements Scope
{
	/**
	 * Apply the scope to a given Eloquent query builder.
	 * @param Builder $builder
	 * @param Model $model
	 */
	public function apply(Builder $builder, Model $model)
	{
		$request = \Request::getPathInfo();
		if (starts_with($request, '/admin/artist_template/')) return;

		$builder->join('artists as a', 'a.id', 'artist_id');

		$builder->whereRaw('artist_templates.deleted_at is null');

		$builder
			->select([
				'artist_templates.*',
				'a.name as artistName',
				'a.website as artistWebsite',
			])->orderBy('name', 'asc');
	}
}