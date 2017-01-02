<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//Route::feeds();

use Illuminate\Http\Request;
use Roumen\Feed\Feed;

Route::get('tzdetect', array('as' => 'tzdetect', function ()
{
	return view('gettz');
}));

Route::get('tzpostdetect', array('as' => 'tzpostdetect', function ()
{
	Session::put('tz', $_GET['_tz']);
	Session::put('tz_done', 'done');
	return Redirect::to(url(Session::pull('tz_route')));
}));

Route::get('gigs/test', function()
{
	return view('gigs.test')->with(['latitude' => 0, 'longitude' => 0]);
});

Route::get("gigs/ical", function() {
	ob_start();
	require(public_path("ical.php"));
	return ob_get_clean();
});

Route::get('events', function()
{
	return view('events');
});

Route::get('/', function ()
{
	return view('welcome');
});

Route::get('feed/gigs', function (Request $request)
{
	// create new feed
	/** @var Feed $feed */
	$feed = App::make("feed");

	// multiple feeds are supported
	// if you are using caching you should set different cache keys for your feeds

	// cache the feed for 60 minutes (second parameter is optional)
//	$feed->setCache(60, 'laravelFeedKey');

	// check if there is cached feed and build new only if is not
//	if (!$feed->isCached())
	{
		// creating rss feed with our most recent 20 posts
		$posts = Gigs::getShows($request);
		// set your feed's title, description, link, pubdate and language
		$feed->title = 'Gigs';
		$feed->description = 'Gig data';
		$feed->logo = 'https://giginfo.org/img/giginfo_logo.png';
		$feed->link = url('feed');
		$feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
		if (count($posts) > 0)
			$feed->pubdate = $posts[0]->start;
		$feed->lang = 'en';
		$feed->setShortening(true); // true or false
		$feed->setTextLimit(100); // maximum length of description text
		$feed->setView('vendor.feed.show');

		foreach ($posts as $post)
		{
			// set item's title, author, url, pubdate, description, content, enclosure (optional)*
			$feed->add($post->name, $post->artistName, '', $post->start, $post->description, $post);
		}

	}

	// first param is the feed format
	// optional: second param is cache duration (value of 0 turns off caching)
	// optional: you can set custom cache key with 3rd param as string
	return $feed->render('atom');

	// to return your feed as a string set second param to -1
	// $xml = $feed->render('atom', -1);

});

//Route::get('feed/{format}', function ($format)
//{
//	$posts = [
//		"0" => [
//			'title' => 'Post 1',
//			'link' => 'http://package.dev/post/1',
//			'description' => 'Post 1 description',
//			'author' => ['email' => 'zoxray@gmail.com', 'name' => 'Viktor Pavlov', 'url' => url('/')],
//			'image' => 'http://pavlov.od.ua/images/posts/post-e7d628ade3e3bb1caad4d1c5f95b2090.jpg',
//			'pubdate' => date('D, d M Y H:i:s O')
//		],
//		"1" => [
//			'title' => 'Post 2',
//			'link' => 'http://package.dev/post/2',
//			'description' => 'Post 2 description',
//			'author' => ['email' => 'zoxray@gmail.com', 'name' => 'Viktor Pavlov', 'url' => url('/')],
//			'image' => 'http://pavlov.od.ua/images/posts/post-e7d628ade3e3bb1caad4d1c5f95b2090.jpg',
//			'pubdate' => date('D, d M Y H:i:s O', strtotime("-30 days"))
//		],
//	];
//	$feed = App::make('feed');
//	$feed->setChannel([
//		'title' => 'News',
//		'lang' => $feed->getLang(),
//		'description' => 'Laravel',
//		'link' => $feed->getURL(),
//		'logo' => 'http://package.dev/logo.png',
//		'icon' => 'http://package.dev/favicon.ico',
//		'pubdate' => $feed->getPubdate()
//	]);
//	foreach ($posts as $post)
//	{
//		$feed->addItem([
//			'title' => $post['title'],
//			'link' => $post['link'],
//			'description' => $post['description'],
//			'author' => $post['author'],
//			'enclosure' => $post['image'],
//			'pubdate' => $post['pubdate'],
//		]);
//	}
//	return $feed->render($format);
//});

Route::resource('genre', 'GenreController');
Route::resource('artist', 'ArtistController');
Route::resource('venue', 'VenueController');
Route::resource('member', 'MemberController');
Route::resource('address', 'AddressController');
Route::resource('country', 'CountryController');
//Route::resource('state', 'StateController');
Route::resource('city', 'CityController');
Route::resource('postallocation', 'PostalLocationController');
Route::resource('postalcode', 'PostalCodeController');
Route::resource('locationtype', 'LocationTypeController');
Route::resource('artistgenre', 'ArtistGenreController');
Route::resource('artistmember', 'ArtistMemberController');
Route::resource('instrument', 'InstrumentController');
Route::resource('memberinstrument', 'MemberInstrumentController');
Route::resource('dropdowns', 'DropDownsController');
Route::resource('postcodetype', 'PostCodeTypeController');

//Route::get('/', function ()
//{
//	return View::make('hello');
//});
Route::get('manage-artists', 'Crud\ArtistController@manageCrud');
Route::resource('crudartists', 'Crud\ArtistController');

//Route::group(['namespace' => 'Pages'], function ()
//{
Route::get('location/{query}', [
	'as' => 'location_path',
	'uses' => 'JsonController@getLocation'
]);
//});

//Route
Route::get('search/{table}/{column}/{id?}', 'SearchController@autocomplete');


Auth::routes();

Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::resource('venues', 'VenueController');

Route::resource('streets', 'StreetController');

Route::resource('addresses', 'AddressController');

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate');

Route::get('search', function ()
{
	return view('search');
});

Route::get('autocomplete', function ()
{
	return view('autocomplete');
});

Route::get('find/{table?}', 'SearchController@find');

	Route::resource('gigs', 'GigController');

//Route::get('mapdemo1', function()
//{
//	return view('venues.mapdemo1');
//});

Route::get('gigs/{id}/poster', 'GigController@poster');
Route::get('manage-gigs', 'Crud\GigController@manageCrud');
Route::resource('crudgigs','Crud\GigController');

Route::group(['middleware'=>'auth'], function()
{
	Route::group(['prefix' => 'admin'], function ()
	{
		CRUD::resource('gig', 'Admin\GigCrudController');
		CRUD::resource('venue', 'Admin\VenueCrudController');
		CRUD::resource('artist', 'Admin\ArtistCrudController');
		CRUD::resource('genre', 'Admin\GenreCrudController');
	});
});

Route::get('social/login/redirect/{provider}', ['uses' => 'Auth\AuthController@redirectToProvider', 'as' => 'social.login']);
Route::get('social/login/{provider}', 'Auth\AuthController@handleProviderCallback');