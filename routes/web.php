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


// ログインしてない人
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/sake/prefecture/{prefecture}', 'Viewer\SakeController@prefectureIndex');

Route::get('/sake/{id}', 'Viewer\SakeController@show');
Route::get('/', 'Viewer\TopController@welcome');
Route::post('/sake/search', 'Viewer\SakeController@search');
Route::get('/sake/{sake_id}/{page}', 'Viewer\SakeController@pageSet');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');

// ログイン済みルート
Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/maintenance', 'Maintenance\MaintenanceController@index');

    // このあたりresourcesでまとめられないか
    Route::resource('/maintenance/sake',
        '\App\Http\Controllers\Maintenance\SakeController',
        ['only'=>['create','store','edit','update','show','index']]);
    Route::get('/maintenance/sake/{sake_id}/{page}', 'Maintenance\SakeController@pageSet');
    Route::post('/maintenance/sake/createconfirm', 'Maintenance\SakeController@createConfirm')->name('createconfirm');
    Route::post('/maintenance/sake/createcomplete', 'Maintenance\SakeController@createComplete')->name('createcomplete');
    Route::post('/maintenance/sake/{id}/editconfirm', 'Maintenance\SakeController@editConfirm')->name('editconfirm');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/maintenance/sake/search', 'Maintenance\SakeController@search');

});
