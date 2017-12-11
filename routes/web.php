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
Route::post('/quizzes/quiz/{collection}/results', 'CollectionsController@results');
Route::get('/create-question/{collection}', 'CollectionsController@newquestion');
Route::post('/create-quiz', 'CollectionsController@create');
Route::get('/edit-quiz/{collection}', 'CollectionsController@edit');
Route::post('/edit-quiz/{collection}', 'CollectionsController@changeQuizName');
Route::post('/create-question/{collection}', 'QuestionController@store');
Route::get('/edit-quiz/{collection}/question/{question}', 'QuestionController@showEditQuestion');
Route::post('/edit-quiz/{collection}/question/{question}', 'QuestionController@editQuestion');
Route::delete('/delete-quiz/{collection}/question/{question}', 'QuestionController@destroy');
Route::delete('/delete-quiz/{collection}', 'CollectionsController@destroy');