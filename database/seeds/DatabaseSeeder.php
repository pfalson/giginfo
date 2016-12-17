<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		$tables = [
			'GigSeeder'
		];

		foreach ($tables as $table)
		{
			$this->call($table);
		}
	}
}
