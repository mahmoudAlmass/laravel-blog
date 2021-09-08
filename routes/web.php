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
Route::group(['middleware' => ['web']], function () {

    Route::get('/','pagesController@index');
    Route::get('/abute','pagesController@abute');
    Route::get('/category','pagesController@category');

    Route::post('/posts/show_me','postController@show_categories');

    Route::resource('posts','postController');
    Route::resource('comments','commentsController');

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');


});
