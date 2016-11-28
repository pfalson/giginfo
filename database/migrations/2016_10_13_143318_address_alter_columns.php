<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddressAlterColumns extends Migration
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
	        $table->dropColumn('street1');
	        $table->dropColumn('street2');
	        $table->string('street_number');
	        $table->unsignedInteger('street_id');

	        $table->foreign('street_id')->references('id')->on('streets')
		        ->onDelete('restrict')
		        ->onUpdate('restrict');

	        $table->unique(['street_number', 'street_id', 'city_id']);
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
		    $table->string('street1');
		    $table->string('street2');
		    $table->dropColumn('street_number');
		    $table->dropColumn('street_id');
		    $table->dropForeign('addresses_street_id_foreign');
		    $table->dropUnique('addresses_street_number_street_id_city_id_unique');
	    });
    }
}
