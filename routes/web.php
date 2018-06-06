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

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/home', 'HomeController@index')->name('home');

//Route::auth();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/admin','admin\DashboardController@index')->name('admin');
    Route::get('/admin','admin\DashboardController@index')->name('admin');

    Route::prefix('admin')->group(function () {
        Route::get('users','admin\UsersController@index')->name('admin/users');
        Route::post('users/delete', 'admin\UsersController@delete')->name('admin/users/delete');
        Route::get('users/get/{id}', 'admin\UsersController@getUser')->name('admin/users/get');
        Route::post('users/save', 'admin\UsersController@save')->name('admin/users/save');
    });
});
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
