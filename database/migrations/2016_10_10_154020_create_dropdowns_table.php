<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDropdownsTable extends Migration
{

	public function up()
	{
		Schema::create('dropdowns', function (Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name')->index();
			$table->string('code', 10);
			$table->string('value');
		});
	}

	public function down()
	{
		Schema::drop('dropdowns');
	}
}