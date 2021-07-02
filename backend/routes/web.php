<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// Common Route
	Route::get('/verify',['as'=>'verify','uses'=>'GuestController@Verify']);
	Route::get('/ses',['as'=>'ses','uses'=>'AuthController@Ses']);
	Route::get('/logout',['as'=>'logout','uses'=>'AuthController@Logout']);
	Route::get('auth/logout',['as'=>'auth.logout','uses'=>'Auth\AuthController@logout']);

// Guest Route
	Route::group(['middleware'=>'web'], function() {	
		
		Route::get('/', ['as'=>'guest.home','uses'=>'GuestController@HomeView']);

		Route::get('/aboutUs', ['as'=>'guest.aboutUs','uses'=>'GuestController@aboutUsView']);

		Route::get('/traning', ['as'=>'guest.traning','uses'=>'GuestController@TraningView']);

		Route::get('/propertyInspection', ['as'=>'guest.propertyInspection','uses'=>'GuestController@propertyInspectionView']);

		Route::get('/rehabRenovation', ['as'=>'guest.rehabRenovation','uses'=>'GuestController@RehabRenovationView']);

		Route::get('/structuralRehab', ['as'=>'guest.structuralRehab','uses'=>'GuestController@StructuralRehabView']);

		Route::get('/environmental', ['as'=>'guest.environmental','uses'=>'GuestController@EnvironmentalView']);

		Route::get('/trashOuts', ['as'=>'guest.trashOuts','uses'=>'GuestController@TrashOutsView']);
		Route::get('/repairs', ['as'=>'guest.repairs','uses'=>'GuestController@RepairsView']);

		Route::get('/lawn', ['as'=>'guest.lawn','uses'=>'GuestController@LawnView']);

		Route::get('/roofing', ['as'=>'guest.roofing','uses'=>'GuestController@RoofingView']);



		Route::post('/register', ['as'=>'guest.register.store','uses'=>'GuestController@RegisterStore']);
		Route::post('/subscribe', ['as'=>'guest.subscribe.store','uses'=>'GuestController@SubscribeStore']);
	});
//Auth Rouet
	
	Route::group(['middleware'=>'web'], function() {	
		Route::get('/signin', ['as'=>'login','uses'=>'AuthController@LoginView']);
		Route::get('/login', ['as'=>'auth.login','uses'=>'AuthController@LoginView']);
		Route::post('/login', ['as'=>'auth.login.store','uses'=>'AuthController@LoginViewStore']);

		Route::get('/registration', ['as'=>'auth.registration','uses'=>'AuthController@RegistrationView']);
		Route::post('/registration', ['as'=>'auth.registration.store','uses'=>'AuthController@RegistrationViewStore']);
	});


//Admin Route
	/*Route::group(['prefix' => 'admin-panel', 'middleware'=>['web'] ], function() {
		Route::get('/dashboard', ['as'=>'admin.dashboard','uses'=>'AdminController@DashboardView']);
	})*/

	Route::group(['prefix' => 'admin-panel', 'middleware'=>['auth:web'] ], function() {	
		Route::get('/dashboard', ['as'=>'admin.dashboard','uses'=>'AdminController@DashboardView']);
		Route::get('/content', ['as'=>'admin.content','uses'=>'AdminController@ContentView']);

		Route::post('/content', ['as'=>'admin.content.store','uses'=>'AdminController@ContentViewStore']);
	  Route::put('/content', ['as'=>'admin.content.update','uses'=>'AdminController@ContentUpdate']);
		Route::delete('/content/{id}', ['as'=>'admin.content.delete','uses'=>'AdminController@ContentDestroy'])->where(['id' => '[0-9]+']);

		Route::post('/contentSearch', ['as'=>'admin.contentSearch.store','uses'=>'AdminController@ContentSearchViewStore']);

		Route::get('/contentOne', ['as'=>'admin.contentOne','uses'=>'AdminController@ContentOneView']);

		Route::delete('/contentOne/{id}', ['as'=>'admin.contentOne.delete','uses'=>'AdminController@ContentOneDestroy'])->where(['id' => '[0-9]+']);

		Route::post('/contentOneSearch', ['as'=>'admin.contentOneSearch.store','uses'=>'AdminController@ContentOneSearchViewStore']);

		
	});