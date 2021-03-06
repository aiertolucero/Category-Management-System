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

Route::get('/login', function(){
		return view('login');
	})->name('login');

Route::post('/login', 'LoginController@login');

Route::group(['middleware' => 'auth'], function()
{
	Route::get('/', 'HomeController@index');
	Route::post('/Category', 'HomeController@addCategory');
	Route::put('/Category', 'HomeController@updateCategory');
	Route::delete('/Category', 'HomeController@deleteCategory');
});
