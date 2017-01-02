<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostalToAddresses extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('addresses', function (Blueprint $table)
		{
			$table->double('longitude')->nullable();
			$table->double('latitude')->nullable();
			$table->unsignedInteger('postalcode_id')->nullable();
			$table->foreign('postalcode_id')->references('id')->on('postalcodes')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('addresses', function (Blueprint $table)
		{
			$table->dropForeign('addresses_postalcode_id_foreign');
			$table->dropColumn('postalcode_id');
			$table->dropColumn('longitude');
			$table->dropColumn('latitude');
		});
	}
}
