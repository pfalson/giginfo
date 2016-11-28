<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration
{

	public function up()
	{
		Schema::table('venues', function (Blueprint $table)
		{
			$table->foreign('address_id')->references('id')->on('addresses')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
		Schema::table('addresses', function (Blueprint $table)
		{
			$table->foreign('city_id')->references('id')->on('cities')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
		Schema::table('states', function (Blueprint $table)
		{
			$table->foreign('country_id')->references('id')->on('countries')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
		Schema::table('cities', function (Blueprint $table)
		{
			$table->foreign('state_id')->references('id')->on('cities')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
		Schema::table('postalcodes', function (Blueprint $table)
		{
			$table->foreign('postallocation_id')->references('id')->on('postallocations')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
		Schema::table('postalcodes', function (Blueprint $table)
		{
			$table->foreign('locationtype_id')->references('id')->on('locationtypes')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
		Schema::table('postalcodes', function (Blueprint $table)
		{
			$table->foreign('postcodetype_id')->references('id')->on('postcodetypes')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
		Schema::table('postalcodes', function (Blueprint $table)
		{
			$table->foreign('city_id')->references('id')->on('cities')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
		Schema::table('artist_genres', function (Blueprint $table)
		{
			$table->foreign('artist_id')->references('id')->on('artists')
				->onDelete('cascade')
				->onUpdate('restrict');
		});
		Schema::table('artist_genres', function (Blueprint $table)
		{
			$table->foreign('genre_id')->references('id')->on('genres')
				->onDelete('cascade')
				->onUpdate('restrict');
		});
		Schema::table('artist_members', function (Blueprint $table)
		{
			$table->foreign('artist_id')->references('id')->on('artists')
				->onDelete('cascade')
				->onUpdate('restrict');
		});
		Schema::table('artist_members', function (Blueprint $table)
		{
			$table->foreign('member_id')->references('id')->on('members')
				->onDelete('cascade')
				->onUpdate('restrict');
		});
		Schema::table('member_instruments', function (Blueprint $table)
		{
			$table->foreign('member_id')->references('id')->on('members')
				->onDelete('cascade')
				->onUpdate('restrict');
		});
		Schema::table('member_instruments', function (Blueprint $table)
		{
			$table->foreign('instrument_id')->references('id')->on('instruments')
				->onDelete('cascade')
				->onUpdate('restrict');
		});
		Schema::table('gig', function (Blueprint $table)
		{
			$table->foreign('artist_id')->references('id')->on('artists')
				->onDelete('cascade')
				->onUpdate('restrict');
		});
		Schema::table('gig', function (Blueprint $table)
		{
			$table->foreign('venue_id')->references('id')->on('venues')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
		Schema::table('gig', function (Blueprint $table)
		{
			$table->foreign('age')->references('id')->on('dropdowns')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
		Schema::table('gig', function (Blueprint $table)
		{
			$table->foreign('type')->references('id')->on('dropdowns')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('venues', function (Blueprint $table)
		{
			$table->dropForeign('venues_address_id_foreign');
		});
		Schema::table('addresses', function (Blueprint $table)
		{
			$table->dropForeign('addresses_city_id_foreign');
		});
		Schema::table('states', function (Blueprint $table)
		{
			$table->dropForeign('states_country_id_foreign');
		});
		Schema::table('cities', function (Blueprint $table)
		{
			$table->dropForeign('cities_state_id_foreign');
		});
		Schema::table('postalcodes', function (Blueprint $table)
		{
			$table->dropForeign('postalcodes_postallocation_id_foreign');
		});
		Schema::table('postalcodes', function (Blueprint $table)
		{
			$table->dropForeign('postalcodes_locationtype_id_foreign');
		});
		Schema::table('postalcodes', function (Blueprint $table)
		{
			$table->dropForeign('postalcodes_postcodetype_id_foreign');
		});
		Schema::table('postalcodes', function (Blueprint $table)
		{
			$table->dropForeign('postalcodes_city_id_foreign');
		});
		Schema::table('artist_genres', function (Blueprint $table)
		{
			$table->dropForeign('artist_genres_artist_id_foreign');
		});
		Schema::table('artist_genres', function (Blueprint $table)
		{
			$table->dropForeign('artist_genres_genre_id_foreign');
		});
		Schema::table('artist_members', function (Blueprint $table)
		{
			$table->dropForeign('artist_members_artist_id_foreign');
		});
		Schema::table('artist_members', function (Blueprint $table)
		{
			$table->dropForeign('artist_members_member_id_foreign');
		});
		Schema::table('member_instruments', function (Blueprint $table)
		{
			$table->dropForeign('member_instruments_member_id_foreign');
		});
		Schema::table('member_instruments', function (Blueprint $table)
		{
			$table->dropForeign('member_instruments_instrument_id_foreign');
		});
		Schema::table('gig', function (Blueprint $table)
		{
			$table->dropForeign('gig_artist_id_foreign');
		});
		Schema::table('gig', function (Blueprint $table)
		{
			$table->dropForeign('gig_venue_id_foreign');
		});
		Schema::table('gig', function (Blueprint $table)
		{
			$table->dropForeign('gig_age_foreign');
		});
		Schema::table('gig', function (Blueprint $table)
		{
			$table->dropForeign('gig_type_foreign');
		});
	}
}