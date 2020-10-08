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

Route::get('/','PostController@index')->name('index');

// 新增文章
Route::get('/post', 'PostController@create')->name('post.create');
Route::post('/post/store','PostController@store')->name('post.store');

// 閱讀文章
Route::get('/show/{id}', 'PostController@show')->name('post.show');

// 編輯文章
Route::get('/edit/{id}','PostController@edit')->name('post.edit');
//送出編輯文章
Route::post('/update','PostController@update')->name('post.update');

// 刪除文章
Route::delete('/post/{id}','PostController@destroy')->name('post.delete');
// 送出評論
Route::post('/comment','PostController@comment')->name('post.comment');

// 搜尋文章
Route::get('/search','PostController@search')->name('post.search');

// 顯示該作者文章
Route::get('/name/{name}','PostController@name')->name('post.name');


Route::get('/home', 'HomeController@index')->name('home');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

