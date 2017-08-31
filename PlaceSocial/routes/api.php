<?php

use Illuminate\Http\Request;
use App\Models\Article;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*
|======================================================
| API method endpoints
|======================================================
*/
Route::group(['middleware' => 'token'], function() {
	// Permission: admin
	Route::group(['middleware' => 'role:admin'], function(){

		//insert item
		Route::post('/articles', 'ArticleController@store');

		//update item
		Route::post('/articles/{article}/update', 'ArticleController@update');

		//delete item
		Route::get('/articles/{article}/delete', 'ArticleController@delete');
	});

	// Permission: user
	Route::group(['middleware' => 'role:user'], function() {

		// read all records 
		Route::get('/articles', 'ArticleController@index');

		// show item's detail
		Route::get('/articles/{article}', 'ArticleController@show');
	});

});

/*
|=============================================
| API Authorization with token API
|=============================================
*/
    Route::post('/login', 'UserController@authenticate');

    Route::post('/register', 'UserController@register');

    Route::get('/logout', 'UserController@logout');
