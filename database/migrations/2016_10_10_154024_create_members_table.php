<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMembersTable extends Migration {

	public function up()
	{
		Schema::create('members', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name')->unique();
			$table->tinyInteger('primary_role')->unsigned();
			$table->text('biography');
		});
	}

	public function down()
	{
		Schema::drop('members');
	}
}