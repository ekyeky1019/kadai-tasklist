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


Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', function () {
    return view('welcome');
});

//ユーザ登録
Route::get("signup", "Auth\RegisterController@showRegistrationForm")->name("signup.get");
Route::post("signup", "Auth\RegisterController@register")->name("signup.post");

// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

/*
Route::get("tasks/{id}", "TasksController@show");
Rout::post("tasks", "TasksController@store");
Route::put("tasks/{id}", "TasksController@update");
Rute::delete("tasks/{id}", "TasksController@destroy");

Route::get("tasks", "TasksController@index")->name("tasks.index");
//新規作成用の入力フォームページ
Route::get("tasks/create", "TsaksController@create")->name("tasks.create");
//更新用の入力フォームページ
Route::get("tasks/{id}/edit", "TasksController@edit")->name("tasks.edit");
*/
//上記項目すべてを1行で実装↓
Route::resource("tasks", "TasksController");