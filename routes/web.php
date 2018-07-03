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


$router->pattern('query_id', '[0-9]+');
$router->pattern('relazione_id', '[0-9]+');
$router->pattern('preventivo_id', '[0-9]+');
$router->pattern('documento_id', '[0-9]+');
$router->pattern('post_id', '[0-9]+');
$router->pattern('utente_id', '[0-9]+');

//Auth::routes();
    
// Authentication Routes

//Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login_post');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.request');




// la home diventa il mio loginForm
Route::get('/','Auth\LoginController@showLoginForm')->name('login');



////////////////////////////////
// Disable registration route //
////////////////////////////////
/*Route::match(['get', 'post'], 'register', function(){
    return redirect('/');
});*/



Route::get('admin/home', 'Admin\HomeController@index')->name('home')->middleware('log');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ROUTE ACCESSIBILI SOLO AL PROFILO ADMIN: oltre a dover essere loggato perché estende AdminController, è in un  //
// groupMiddleware che verifica se sono Admin                                                                     //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => ['admin']], function () {

		

	Route::get('/admin/prova/', function(){
		Volontario::all();
	});


    ////////////////////////////////////////////////
    // creazione nuovo utente (registration form) //
    ////////////////////////////////////////////////
    Route::get('admin/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('admin/register', 'Auth\RegisterController@register');
    Route::get('admin/utenti', 'Auth\RegisterController@elencoUtenti')->name('utenti');
    Route::post('admin/utenti/elimina/{utente_id}', 'Auth\RegisterController@destroyUtente')->name('utenti.elimina');
    Route::get('admin/utenti/edita/{utente_id}', 'Auth\RegisterController@editaUtente')->name('utenti.edita');
    Route::post('admin/utenti/modifica/{utente_id}', 'Auth\RegisterController@modificaUtente')->name('utenti.modifica');




	Route::resource('admin/associazioni', 'Admin\AssociazioniController');

    Route::post('admin/volontari/search', ['uses' => 'Admin\VolontariController@search', 'as' => 'volontari.search']);
    Route::get('admin/volontari/{query_id?}', ['uses' => 'Admin\VolontariController@index', 'as' => 'volontari.index']);
    Route::resource('admin/volontari', 'Admin\VolontariController', ['except' => ['index']]);

    Route::post('admin/posts/slug_ajax', ['uses' => 'Admin\PostsController@slugAjax']);
    Route::any('admin/posts/upload', ['uses' => 'Admin\PostsController@upload', 'as' => 'posts.upload']);
    Route::resource('admin/posts', 'Admin\PostsController', ['except' => ['show']]);

    Route::get('admin/documenti/upload', ['uses' => 'Admin\DocumentiController@formUpload', 'as' => 'documenti.form-upload']);
    Route::post('admin/documenti/upload', ['uses' => 'Admin\DocumentiController@upload', 'as' => 'documenti.upload']);
    Route::get('admin/documenti/modifica/{documento_id}', ['uses' => 'Admin\DocumentiController@modifica', 'as' => 'documenti.modifica']);
    Route::post('admin/documenti/aggiorna/{documento_id}', ['uses' => 'Admin\DocumentiController@aggiorna', 'as' => 'documenti.aggiorna']);
    Route::post('admin/documenti/elimina/{documento_id}', ['uses' => 'Admin\DocumentiController@elimina', 'as' => 'documenti.elimina']);


});


Route::get('admin/posts/{post_id}', 'Admin\PostsController@show')->name('posts.show');

Route::get('admin/documenti', ['uses' => 'Admin\DocumentiController@index', 'as' => 'documenti.index']);

Route::any('admin/preventivi/carica_volontari_ajax', 'Admin\PreventiviController@caricaVolontariAjax');
Route::post('admin/preventivi/search', ['uses' => 'Admin\PreventiviController@search', 'as' => 'preventivi.search'])->middleware('log');

Route::post('admin/preventivi/geocode_ajax', ['uses' => 'Admin\PreventiviController@geocodeAjax', 'as' => 'preventivi.geocode_ajax']);
Route::post('admin/preventivi/reverse_geocode_ajax', ['uses' => 'Admin\PreventiviController@reverseGeocodeAjax', 'as' => 'preventivi.reverse_geocode_ajax']);

Route::get('admin/preventivi/{query_id?}', ['uses' => 'Admin\PreventiviController@index', 'as' => 'preventivi.index'])->middleware('log');
Route::get('admin/preventivi/apri/{preventivo_id}', ['uses' => 'Admin\PreventiviController@apri', 'as' => 'preventivi.apri'])->middleware('log');
Route::resource('admin/preventivi', 'Admin\PreventiviController')->except(['index'])->middleware('log');

Route::get('admin/relazioni/crea-da-preventivo/{preventivo_id}', ['uses' => 'Admin\RelazioniController@creaDaPreventivo', 'as' => 'relazioni.crea-da-preventivo']);
Route::post('admin/relazioni/search', ['uses' => 'Admin\RelazioniController@search', 'as' => 'relazioni.search'])->middleware('log');
Route::post('admin/relazioni/export_ore', ['uses' => 'Admin\RelazioniController@exportOre', 'as' => 'relazioni.export_ore']);
Route::get('admin/relazioni/stampa/{relazione_id?}', ['uses' => 'Admin\RelazioniController@stampa', 'as' => 'relazioni.stampa'])->middleware('log');

Route::get('admin/relazioni/{query_id?}', ['uses' => 'Admin\RelazioniController@index', 'as' => 'relazioni.index'])->middleware('log');

Route::resource('admin/relazioni', 'Admin\RelazioniController')->except(['index', 'create']);


Route::get('admin/pdf', function(){
	$pdf = PDF::loadHTML('<h1>Test</h1>');
	return $pdf->stream();
});


	//////////////////////////////////////////////////
	// fine ROUTE ACCESSIBILI SOLO AL PROFILO ADMIN	//
	/////////////////////////////////////////////////
