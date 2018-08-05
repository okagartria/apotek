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

Route::get('/','ObatController@index');

Route::resource('obat', 'ObatController');
Route::resource('satuan', 'SatuanController');
Route::resource('mutasi', 'MutasiController');
Route::get('penerimaan', 'LaporanController@penerimaan');
Route::get('penerimaan/excel', 'LaporanController@excelpenerimaan');
Route::get('pengeluaran/excel', 'LaporanController@excelpengeluaran');
Route::get('bulanan/excel', 'LaporanController@excelbulanan');

Route::get('pengeluaran', 'LaporanController@pengeluaran');
Route::get('bulanan', 'LaporanController@bulanan');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
