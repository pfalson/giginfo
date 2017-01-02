<?php

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityToArtists extends Migration
{
	const tableName = 'artists';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table(static::tableName, function(Blueprint $table)
		{
			$table->unsignedInteger('city_id');
		});

		$state = State::whereName('Oregon')->first();
		$city = City::whereName('Portland')->where('state_id', $state->id)->first();

		DB::table(static::tableName)->update(['city_id' => $city->id]);

		Schema::table(static::tableName, function(Blueprint $table)
		{
			$table->dropUnique('artists_name_unique');
			$table->unique(['name', 'city_id']);
			$table->foreign('city_id')->references('id')->on('cities')
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
        //
    }
}
