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
    return view('welcome');
});
Route::get('/tasks/new', 'TasksController@new')->name('tasks.new');
Route::post('/tasks', 'TasksController@create')->name('tasks.create');
Route::get('/tasks', 'TasksController@index')->name('tasks.index');
Route::get('/tasks/{id}/edit', 'TasksController@edit')->name('tasks.edit');
Route::post('/tasks/{id}', 'TasksController@update')->name('tasks.update');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
