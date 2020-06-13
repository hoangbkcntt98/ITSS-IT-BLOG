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
    return view('layouts.home');
})->name('/');
Route::resource('user','ProfileController');
Auth::routes();
Route::get('/search', 'ProfileController@search')->name('search');
Route::delete('/del_user', 'ProfileController@destroy')->name('del_user');
Route::get('/home', 'HomeController@index')->name('home');
