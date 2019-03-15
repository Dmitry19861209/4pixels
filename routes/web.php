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
    return redirect('/home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    /* Users */
    Route::resource('users', 'UsersController');
    Route::get('/users', 'UsersController@index')->name('users');
    Route::post('users-all', 'UsersController@getAllUsers');
    Route::post('user-by-id/{id}', 'UsersController@getUserById');
    Route::post('users/{id}', 'UsersController@update');

    /* Departments */
    Route::resource('departments', 'DepartmentsController');
    Route::get('/departments', 'DepartmentsController@index')->name('departments');
    Route::post('departments-all', 'DepartmentsController@getAllDepartments');
    Route::post('department-by-id/{id}', 'DepartmentsController@getDepartmentById');
    Route::post('departments/{id}', 'DepartmentsController@update');
    Route::post('check-user', 'DepartmentsController@checkUser');

});

