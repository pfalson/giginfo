<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistTemplateTypes extends Migration
{
	const tableName = 'artist_template_types';
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
		    $table->unsignedInteger('templatetype_id');
		    $table->unsignedInteger('artist_template_id');
		    $table->unique(['artist_id', 'artist_template_id', 'templatetype_id'], 'artist_template_types_unique');
		    $table->foreign('artist_id')->references('id')->on('artists')
			    ->onDelete('restrict')
			    ->onUpdate('restrict');
		    $table->foreign('artist_template_id')->references('id')->on('artist_templates')
			    ->onDelete('restrict')
			    ->onUpdate('restrict');
		    $table->foreign('templatetype_id')->references('id')->on('dropdowns')
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
