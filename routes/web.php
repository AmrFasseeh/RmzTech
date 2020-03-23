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

Route::group(['middleware' => ['role:Admin']], function () {
    Route::resource('settings', 'SettingController')->only('show', 'store');
    Route::resource('businesshours', 'BusinessHourController')->only('show', 'create', 'store');
    Route::get('users/create', 'UsersController@create')->name('add.user');
    Route::post('users/create', 'UsersController@store')->name('store.user');
    Route::get('users/edit/{user}', 'UsersController@edit')->name('edit.user');

    Route::post('users/delete', 'UsersController@destroy')->name('delete.user');
    Route::get('/users', 'UsersController@index')->name('show.users');

});
Route::group(['middleware' => ['role:employee']], function () {
    // Route::get('/', 'EmployeeController@index')->name('emp.landing');
    Route::get('/home', 'EmployeeController@index')->name('emp.home');
    Route::get('/viewusers', 'EmployeeController@viewUsers')->name('view.users');
    Route::get('/employee/monthly', 'EmployeeController@GetEmpMonth')->name('monthly.emp');
    Route::get('/employee/lastmonth', 'EmployeeController@GetEmpLastMonth')->name('lastmonth.emp');

});

Route::get('/edituser', 'EmployeeController@editUser')->name('edit.emp');
Route::post('users/update', 'UsersController@update')->name('update.user');

Route::get('/ajax/show', 'EmployeeController@show');


Route::get('/admins', 'AdminsController@index')->name('show.admins');

Route::get('/records', 'UsRecordsController@index')->name('show.records');



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


Route::get('/ajax/populatecalendar', 'EventController@populateCalendar');
Route::post('/ajax/createvent', 'EventController@createEvent');
Route::post('/ajax/updatevent', 'EventController@updateEvent');
Route::post('/ajax/deletevent', 'EventController@deleteEvent');
Route::get('/ajax/countevents', 'EventController@countEvents')->name('count.events');

Route::get('holidays', 'HolidayController@index')->name('add.holidays');
Route::post('/ajax/saveholiday', 'HolidayController@store')->name('save.holidays');
Route::get('/ajax/getholidays', 'HolidayController@getHolidays')->name('get.holidays');
Route::post('/ajax/delholidays', 'HolidayController@deleteHolidays')->name('delete.holidays');
Route::post('/ajax/editholidays', 'HolidayController@editHolidays')->name('edit.holidays');



Route::get('/allrecords', 'EmployeeController@getAllRecords')->name('emp.allrecords');
Route::get('/ajax/listyears', 'EmployeeController@listYears')->name('list.years');
Route::get('/ajax/listmonths/{year}', 'EmployeeController@listMonths')->name('list.months');
Route::get('/empMonth/{year}/{month}', 'EmployeeController@showYearMonth')->name('emp.month');


//Company routes
Route::get('companies', 'CompanyController@index');
Route::post('companies/add', 'CompanyController@store')->name('add.company');
// Route::get('/companies/edit/{user}', 'CompanyController@edit')->name('edit.company');
Route::post('companies/update/{company}', 'CompanyController@update')->name('update.company');
Route::post('companies/delete', 'CompanyController@destroy')->name('delete.company');

Auth::routes();
