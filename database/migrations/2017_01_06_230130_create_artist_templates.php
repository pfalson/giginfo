<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistTemplates extends Migration
{
	const tableName = 'artist_templates';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create(static::tableName, function (Blueprint $table)
	    {
		    $table->increments('id');
		    $table->timestamps();
		    $table->softDeletes();
		    $table->unsignedInteger('artist_id');
		    $table->string('name');
		    $table->text('source');
		    $table->unique(['artist_id', 'name']);
		    $table->foreign('artist_id')->references('id')->on('artists')
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
