<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCityFromAddress extends Migration
{
	const tableName = 'addresses';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(static::tableName, function(Blueprint $table)
	    {
		    $table->dropUnique('addresses_street_number_street_id_city_id_unique');
		    $table->dropColumn('city_id');
		    $table->unique(['street_number', 'street_id', 'postalcode_id']);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(static::tableName, function(Blueprint $table)
	    {
		    $table->dropUnique('addresses_street_number_street_id_postalcode_id_unique');
		    $table->integer('city_id')->nullable();
		    $table->unique(['street_number', 'street_id', 'city_id']);
	    });
    }
}
