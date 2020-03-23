<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('admin/', function(){
	return redirect('admin/login');

});

/*
Route::prefix('admin')->group(function () {
	
	Route::get('/login', 'Auth\LoginController@showAdminLoginForm');
	Route::post('/login', 'Auth\LoginController@adminLogin')->name('postAdminLogin');
	Route::get('/register', 'Auth\RegisterController@showAdminRegisterForm');
	Route::post('/register', 'Auth\RegisterController@createAdmin');
	
    Auth::routes();
    Route::middleware('auth:admin')->group(function () {
        
    });    
});
*/



Auth::routes();
Route::view('/home', 'home')->middleware('auth');
Route::post('/draw', 'HomeController@draw')->middleware('auth');


Route::group(['prefix' => 'admin'],function(){
	
    Route::get('/login', 'Auth\LoginController@showAdminLoginForm');
	Route::get('/register', 'Auth\RegisterController@showAdminRegisterForm');

	Route::post('/login', 'Auth\LoginController@adminLogin');
	Route::post('/register', 'Auth\RegisterController@createAdmin');
	
	Route::get('/logout', function(){
		return redirect('admin/login');

	});
	
	Route::middleware('auth:admin')->group(function () {
        Route::get('/home', 'Admin\AdminHomeController@index');
        Route::post('/draw', 'Admin\AdminHomeController@draw');
		
    }); 
	
});

