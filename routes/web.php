<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/redirect', 'SocialAuthTwitterController@redirect');
Route::get('/callback', 'SocialAuthTwitterController@callback');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/userTimeline', function()
{
	return Twitter::getUserTimeline(['screen_name' => 'DuyNguy74518863', 'count' => 20, 'format' => 'json']);
});

Route::get('/homeTimeline', function()
{
	return Twitter::getHomeTimeline(['count' => 20, 'format' => 'json']);
});

Route::get('/mentionsTimeline', function()
{
	return Twitter::getMentionsTimeline(['count' => 20, 'format' => 'json']);
});

Route::get('/tweet', function()
{
	return Twitter::postTweet(['status' => 'Tulip is a beautiful flower', 'format' => 'json']);
});

Route::get('/tweetMedia', function()
{
	$uploaded_media = Twitter::uploadMedia(['media' => File::get(public_path('filename.jpg'))]);
	return Twitter::postTweet(['status' => 'Laravel is beautiful', 'media_ids' => $uploaded_media->media_id_string]);
});