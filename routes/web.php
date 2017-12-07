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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/questions', 'QuestionController@index');
Route::get('/quizzes', 'CollectionsController@index');
Route::get('/quizzes/quiz/{collection}', 'CollectionsController@show');
Route::get('/quizzes/quiz/{collection}/questions', 'CollectionsController@questions');
