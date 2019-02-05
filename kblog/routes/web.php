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

Route::get('/view/{id}','Post\PostController@show');

Route::get('/view','Post\PostController@showall');

Route::get('/create', 'Post\PostController@create');


Route::post('/store' ,'Post\PostController@store');

Route::get('/edit/{id}' ,'Post\PostController@edit')->name('edit');
Route::post('/update/{id}' ,'Post\PostController@update')->name('update');

Route::delete('/delete/{id}' ,'Post\PostController@destroy')->name('destroy');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
