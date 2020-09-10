<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServPmaiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/maintenance', 'Maintenance\MaintenanceController@index');
// Route::get('/maintenance/sake', 'Maintenance\SakeController@index');
Route::get('/maintenance/sake/searched', 'Maintenance\SakeController@searched');

Route::get('/maintenance/sake/prefecture/{prefecture}', 'Maintenance\SakeController@prefectureIndex');

// このあたりresourcesでまとめられないか
Route::resource('/maintenance/sake', '\App\Http\Controllers\Maintenance\SakeController',
['only'=>['create','store',
'edit','update',
'show','index']]
);
// Route::get('/maintenance/sake/create', 'Maintenance\SakeController@create');
Route::post('/maintenance/sake/createconfirm', 'Maintenance\SakeController@createConfirm')->name('createconfirm');
Route::post('/maintenance/sake/{$id}/editconfirm', 'Maintenance\SakeController@createComplete')->name('editconfirm');;

// ログインしてない人
Route::get('/sake/{id}', 'Viewer\SakeController@show');
Route::get('/', 'Home\TopController@welcome');

Route::get('/home', 'HomeController@index')->name('home');
