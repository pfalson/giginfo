<?php

use App\Models\Address;
use App\Models\Timezone;
use App\Repositories\AddressRepository;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimezoneToAddresses extends Migration
{
	const tableName = 'addresses';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table(static::tableName, function (Blueprint $table)
		{
			$table->unsignedInteger('timezone_id');
		});

		$timezone = $longitude = null;
		Address::orderBy('longitude')->each(function ($item, $key) use (&$longitude, &$timezone)
		{
			/** @var Address $item */
			if ($longitude != $item->longitude)
			{
				$longitude = $item->longitude;
				$timezone = AddressRepository::createTimeZone($item->longitude, $item->latitude);
			}
			$item->fill(['timezone_id' => $timezone->id])->save();
		});

		Schema::table(static::tableName, function (Blueprint $table)
		{
			$table->foreign('timezone_id')->references('id')->on('timezones')
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
		Schema::table(static::tableName, function (Blueprint $table)
		{
			$table->dropForeign(['timezone_id']);
			$table->dropColumn('timezone_id');
		});
	}
}
