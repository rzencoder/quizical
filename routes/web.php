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
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
Route::get('/questions', 'QuestionController@index');
Route::get('/quizzes', 'CollectionsController@index');
Route::get('/quizzes/quiz/{collection}', 'CollectionsController@show');
Route::get('/quizzes/quiz/{collection}/questions', 'CollectionsController@questions');
Route::post('/quizzes/quiz/{collection}/results', 'ScoreController@store');
Route::get('/create-question/{collection}', 'CollectionsController@newquestion');
Route::post('/create-quiz', 'CollectionsController@create');
Route::get('/edit-quiz/{collection}', 'CollectionsController@edit');
Route::post('/edit-quiz/{collection}', 'CollectionsController@changeQuizName');
Route::post('/create-question/{collection}', 'QuestionController@store');
Route::get('/edit-quiz/{collection}/question/{question}', 'QuestionController@showEditQuestion');
Route::post('/edit-quiz/{collection}/question/{question}', 'QuestionController@editQuestion');
Route::delete('/delete-quiz/{collection}/question/{question}', 'QuestionController@destroy');
Route::delete('/delete-quiz/{collection}', 'CollectionsController@destroy');

Route::get('/show-results/{collection}', 'ScoreController@show');

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
});
