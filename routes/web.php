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
Route::middleware(['auth'])->group(function () {
    Route::get('/', 'TodoController@index');
    Route::post('/store', 'TodoController@store')->name('store');
    Route::get('/edit/{id}', 'TodoController@edit')->name('edit');
    Route::post('/update/{id}', 'TodoController@update')->name('update');
    Route::get('/delete/{id}', 'TodoController@delete')->name('delete');
    Route::get('/updatestatus/{id}', 'TodoController@updatestatus')->name('updatestatus');
    Route::post('/sendinvitation', 'TodoController@sendinvitation')->name('sendinvitation');
    Route::get('/acceptinvitation/{id}', 'TodoController@acceptinvitation')->name('acceptinvitation');
    Route::get('/denyinvitation/{id}', 'TodoController@denyinvitation')->name('denyinvitation');
    Route::get('/deleteworker/{id}', 'TodoController@deleteworker')->name('deleteworker');
    
});

Auth::routes();

