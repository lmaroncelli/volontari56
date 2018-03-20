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


Auth::routes();


// la home diventa il mio loginForm
Route::get('/','Auth\LoginController@showLoginForm');


Route::get('/home', 'HomeController@index')->name('home');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ROUTE ACCESSIBILI SOLO AL PROFILO ADMIN: oltre a dover essere loggato perché estende AdminController, è in un  //
// groupMiddleware che verifica se sono Admin                                                                     //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Route::group(['middleware' => ['admin']], function () {*/

		Route::resource('admin/associazioni', 'Admin\AssociazioniController');
		Route::resource('admin/volontari', 'Admin\VolontariController');

/*});*/

	//////////////////////////////////////////////////
	// fine ROUTE ACCESSIBILI SOLO AL PROFILO ADMIN	//
	/////////////////////////////////////////////////