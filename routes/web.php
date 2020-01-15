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

Route::get('/', 'MainController@index')->name('landing');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admins', 'AdminsController@index')->name('show.admins');
Route::get('/users', 'UsersController@index')->name('show.users');

Route::get('/records', 'UsRecordsController@index')->name('show.records');


Route::get('/users/create', 'UsersController@create')->name('add.user');
Route::post('users/create', 'UsersController@store')->name('store.user');

Route::get('/users/{user}', 'UsersController@show')->name('show.single');

Route::get('user/record/edit/{record}', 'UsRecordsController@edit')->name('edit.Urecord');
Route::post('user/record/edit', 'UsRecordsController@update')->name('update.Urecord');


Route::get('/users/{user}/{month}', 'UsersController@showMonthly')->name('show.monthly');

Route::get('records/years', 'UsRecordsController@listYears')->name('records.years');
Route::get('records/{year}', 'UsRecordsController@listMonths')->name('records.yearly');
Route::get('records/{year}/{month}/days', 'UsRecordsController@listMonthDays')->name('records.daily');


Route::get('records/{year}/{month}', 'UsRecordsController@showYearMonth')->name('records.monthly');

Route::get('records/{year}/{month}/{day}', 'UsRecordsController@showMonthDays')->name('show.daily');

Route::get('reports/today', 'UsRecordsController@showTodayReport')->name('reports.today');
Route::get('reports/monthly', 'UsRecordsController@showThisMonth')->name('reports.monthly');


Route::resource('settings', 'SettingController')->only('show', 'store');

Route::resource('businesshours', 'BusinessHourController')->only('show', 'create', 'store');

Route::get('/ajax/populatecalendar','EventController@populateCalendar');
Route::post('/ajax/createvent', 'EventController@createEvent');
Route::post('/ajax/updatevent', 'EventController@updateEvent');
Route::post('/ajax/deletevent', 'EventController@deleteEvent');

Auth::routes();


