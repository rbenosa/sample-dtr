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

Route::get('/', 'Controller@index');

Route::post('store-dtr', 'Controller@store_dtr')->name('store.dtr');

Route::post('update-dtr', 'Controller@update_dtr')->name('update.dtr');

Route::get('template-dtr', 'Controller@template_dtr')->name('template.dtr');

Route::post('import-dtr', 'Controller@import_dtr')->name('import.dtr');

Route::post('delete-dtr', 'Controller@delete_dtr')->name('delete.dtr');

Route::post('restore-dtr', 'Controller@restore_dtr')->name('restore.dtr');
