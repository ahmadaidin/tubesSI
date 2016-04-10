<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function (){return redirect('/cabang');});
Route::get('/cabang', 'CabangController@listCabang');
Route::post('/cabang', 'CabangController@addCabang');
Route::get('/nasabah', 'NasabahController@listNasabah');
Route::post('/nasabah', 'NasabahController@addNasabah');
Route::get('/item', 'ItemController@listItem');
Route::post('/item', 'ItemController@addItem');
