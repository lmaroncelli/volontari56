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



////////////////////////////////
// Disable registration route //
////////////////////////////////
Route::match(['get', 'post'], 'register', function(){
    return redirect('/');
});



Route::get('admin/home', 'Admin\HomeController@index')->name('home');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ROUTE ACCESSIBILI SOLO AL PROFILO ADMIN: oltre a dover essere loggato perché estende AdminController, è in un  //
// groupMiddleware che verifica se sono Admin                                                                     //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => ['admin']], function () {

		Route::resource('admin/associazioni', 'Admin\AssociazioniController');

    Route::post('admin/volontari/search', ['uses' => 'Admin\VolontariController@search', 'as' => 'volontari.search']);
    Route::get('admin/volontari/{query_id?}', ['uses' => 'Admin\VolontariController@index', 'as' => 'volontari.index']);
    Route::resource('admin/volontari', 'Admin\VolontariController', ['except' => ['index']]);


});

Route::any('admin/preventivi/carica_volontari_ajax', 'Admin\PreventiviController@caricaVolontariAjax');
Route::resource('admin/preventivi', 'Admin\PreventiviController');


	//////////////////////////////////////////////////
	// fine ROUTE ACCESSIBILI SOLO AL PROFILO ADMIN	//
	/////////////////////////////////////////////////
