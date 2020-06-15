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
Route::get('/user_search', 'ProfileController@search')->name('user_search');
Route::delete('/del_user', 'ProfileController@destroy')->name('del_user');
Route::get('/post_search', 'ProfileController@post_search')->name('post_search');
Route::delete('/del_post', 'ProfileController@destroy_post')->name('del_post');
Route::get('/pro_search', 'ProfileController@pro_search')->name('pro_search');
Route::delete('/del_pro', 'ProfileController@destroy_pro')->name('del_pro');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/list', 'ListController@index')->name('list');
Route::get('/search', 'ListController@search')->name('search');
Route::get('/filter', 'ListController@filter')->name('filter');

Route::get('/product-details', 'ProductDetailsController@index')->name('product_details');
Route::get('/product-details/{id}', 'ProductDetailsController@show')->name('show_product_details');

Route::get('/articles/{id}', 'ArticleController@index')->name('show_article');
Route::post('/articles/{id}','ArticleController@comment')->name('make_comment');
