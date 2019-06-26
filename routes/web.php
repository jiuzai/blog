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

Route::group(['middleware' => ['web']], function () {
    Route::any('admin/login', 'Admin\LoginController@login');
    Route::any('admin/code', 'Admin\LoginController@code');
});

Route::group(['middleware' => ['web','admin.login'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('logout', 'LoginController@logout');
    Route::any('pass', 'IndexController@pass');

    Route::resource('category', 'CategoryController');
});