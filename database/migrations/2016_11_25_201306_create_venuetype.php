<?php

use App\Models\VenueType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVenueType extends Migration
{
	const tableName = 'venuetypes';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create(static::tableName,  function (Blueprint $table)
	    {
		    $table->engine = 'InnoDB';
		    $table->increments('id');
		    $table->timestamps();
		    $table->softDeletes();
		    $table->string('name')->unique();
	    });

	    $establishment = VenueType::firstOrCreate(
		    [
			    'name' => 'Establishment'
		    ]
	    );

	    $house = VenueType::firstOrCreate(
		    [
			    'name' => 'House'
		    ]
	    );

	    Schema::table('venues', function(Blueprint $table)
	    {
		    $table->unsignedInteger('venuetype_id')->after('name')->default('1');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('venues', function(Blueprint $table)
	    {
		    $table->dropColumn('venuetype_id');
	    });

	    Schema::drop(static::tableName);
    }
}