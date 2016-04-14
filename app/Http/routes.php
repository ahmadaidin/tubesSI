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
Route::post('/cabang/get', 'CabangController@getCabang');
Route::put('/cabang', 'CabangController@editCabang');
Route::delete('/cabang', 'CabangController@deleteCabang');

Route::get('/nasabah', 'NasabahController@listNasabah');
Route::post('/nasabah', 'NasabahController@addNasabah');
Route::put('/nasabah', 'NasabahController@editNasabah');
Route::delete('/nasabah', 'NasabahController@deleteNasabah');

Route::get('/item', 'ItemController@listItem');
Route::post('/item', 'ItemController@addItem');
Route::put('/item', 'ItemController@editItem');
Route::delete('/item', 'ItemController@deleteItem');

Route::get('/setor', 'SetorController@listSetor');
Route::post('/setor', 'SetorController@addSetor');
Route::put('/setor', 'SetorController@editSetor');
Route::delete('/setor', 'SetorController@deleteSetor');

Route::get('/jual', 'JualController@listJual');
Route::post('/jual', 'JualController@addJual');
Route::put('/jual', 'JualController@editJual');
Route::delete('/jual', 'JualController@deleteJual');

Route::get('/statistics', function(){
    return redirect('/statistics/penyetoran');
});
Route::match(array('GET', 'POST'), '/statistics/penyetoran', 'StatisticsController@getStatistikPenyetoran');
Route::get('/statistics', function(){
    return redirect('/statistics/penjualan');
});
Route::match(array('GET', 'POST'), '/statistics/penjualan', 'StatisticsController@getStatistikPenjualan');