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

//ログインしなくてもアクセス可能
//タスク一覧
Route::get('/tasks', 'TasksController@index')->name('tasks.index');
//タスク詳細
Route::get('/tasks/{id}/details', 'TasksController@details')->name('tasks.details');
//タスク一覧表示(Vue.Js)
Route::get('/alltasks', 'TasksController@alltasks')->name('tasks.alltasks');

//タスクをスクロールで表示する仮
Route::get('/scroll', 'TasksController@scroll')->name('tasks.scroll');


//ログインしないとアクセスできないようにする(認証middleware auth)
Route::group(['middleware' => 'auth'], function () {
    Route::get('/tasks/new', 'TasksController@new')->name('tasks.new');
    Route::post('/tasks', 'TasksController@create')->name('tasks.create');
    Route::get('/tasks/{id}/edit', 'TasksController@edit')->name('tasks.edit');
    Route::put('/tasks/{id}', 'TasksController@update')->name('tasks.update');
    Route::delete('/tasks/{id}/delete', 'TasksController@destroy')->name('tasks.delete');
    Route::post('/tasks/{id}/resurrection', 'TasksController@resurrection')->name('tasks.resurrection');
    Route::get('/mypage', 'TasksController@mypage')->name('tasks.mypage');
    //管理者画面
    Route::get('/admi', 'TasksController@admi')->name('tasks.admi');
});
Auth::routes();

//ルート(本番環境でALBを設定した際、ヘルスチェックでunhealthyとなるため設置)
Route::get('/', 'TasksController@home')->name('home');
