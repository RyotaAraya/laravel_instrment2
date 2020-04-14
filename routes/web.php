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


Route::get('/tasks', 'TasksController@index')->name('tasks.index');
Route::get('/tasks/{id}/details', 'TasksController@details')->name('tasks.details');
Route::get('/alltasks', 'TasksController@alltasks')->name('tasks.alltasks');


//ログインしないとアクセスできないようにする(認証middleware auth)
Route::group(['middleware' => 'auth'], function () {
    Route::get('/tasks/new', 'TasksController@new')->name('tasks.new');
    Route::post('/tasks', 'TasksController@create')->name('tasks.create');
    Route::get('/tasks/{id}/edit', 'TasksController@edit')->name('tasks.edit');
    Route::put('/tasks/{id}', 'TasksController@update')->name('tasks.update');
    Route::delete('/tasks/{id}/delete', 'TasksController@destroy')->name('tasks.delete');
    Route::post('/tasks/{id}/resurrection', 'TasksController@resurrection')->name('tasks.resurrection');
    Route::get('/mypage', 'TasksController@mypage')->name('tasks.mypage');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
