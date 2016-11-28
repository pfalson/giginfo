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

use App\Gig;

Route::get('/', function ()
{
	return view('welcome');
});
//Route::feeds();
Route::get('feed/{criteria?}', function ($criteria = null)
{
	// create new feed
	$feed = App::make("feed");

	// multiple feeds are supported
	// if you are using caching you should set different cache keys for your feeds

	// cache the feed for 60 minutes (second parameter is optional)
	$feed->setCache(60, 'laravelFeedKey');

	// check if there is cached feed and build new only if is not
	if (!$feed->isCached())
	{
		// creating rss feed with our most recent 20 posts
		$posts = Gigs::getShows($criteria);
		// set your feed's title, description, link, pubdate and language
		$feed->title = 'Your title';
		$feed->description = 'Your description';
		$feed->logo = 'http://yoursite.tld/logo.jpg';
		$feed->link = url('feed');
		$feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
		if (count($posts) > 0)
			$feed->pubdate = $posts[0]->created_at;
		$feed->lang = 'en';
		$feed->setShortening(true); // true or false
		$feed->setTextLimit(100); // maximum length of description text

		foreach ($posts as $post)
		{
			// set item's title, author, url, pubdate, description, content, enclosure (optional)*
			$feed->add($post->title, $post->author, URL::to($post->slug), $post->created, $post->description, $post->content);
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
Route::resource('venu', 'VenuController');
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
Route::resource('gig', 'GigController');
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
Route::get('search/autocomplete', 'SearchController@autocomplete');


Auth::routes();

Route::get('/home', 'HomeController@index');

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