<?php

use App\Http\Controllers\HomeController;

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
Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('student')->group(function () {
    Route::get('', 'QuestionController@index')->name('student.dashboard');
    Route::get('/quiz/{quiz}', 'QuestionController@show')->name('quiz.show');
    Route::get('/quiz/{quiz}/questions', 'QuestionController@questions')->name('quiz.questions');
    Route::post('/quiz/{quiz}/results', 'QuestionController@results')->name('quiz.results');
    //Authentication
    Route::get('/update/password', 'QuestionController@showChangePasswordForm')->name('changeUserPasswordForm');;
    Route::post('/update/password', 'QuestionController@changePassword')->name('changePassword');
    Route::get('/update', 'QuestionController@showChangeUserDetailsForm')->name('changeUserDetailsForm');;
    Route::post('/update', 'QuestionController@changeUserDetails')->name('changeUserDetails');
});

Route::prefix('teacher')->group(function() {
    Route::get('/create-question/{quiz}', 'QuizController@newQuestion')->name('quiz.newQuestion');
    Route::post('/create-quiz', 'QuizController@create')->name('quiz.create');
    Route::get('/edit-quiz/{quiz}', 'QuizController@edit')->name('quiz.editForm');
    Route::post('/edit-quiz/{quiz}', 'QuizController@changeQuizName')->name('quiz.edit');
    Route::post('/create-question/{quiz}', 'QuizController@store')->name('quiz.createQuestion');
    Route::get('/edit-quiz/{quiz}/question/{question}', 'QuizController@showEditQuestion')->name('quiz.editQuestionForm');
    Route::post('/edit-quiz/{quiz}/question/{question}', 'QuizController@editQuestion')->name('quiz.editQuestion');
    Route::delete('/delete-quiz/{quiz}/question/{question}', 'QuizController@destroyQuestion')->name('quiz.deleteQuestion');
    Route::delete('/delete-quiz/{quiz}', 'QuizController@destroy')->name('quiz.delete');
    Route::post('/show-results/{quiz}', 'QuizController@show')->name('quiz.showResults');
    Route::post('/present-results/{quiz}', 'QuizController@present')->name('quiz.presentResults');
    Route::post('/present-results/{quiz}/data', 'QuizController@presentData')->name('quiz.presentResultsData');
    //Authentication
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::get('/update/password', 'AdminController@showChangePasswordForm')->name('admin.changePasswordForm');
    Route::post('/update/password', 'AdminController@changePassword')->name('admin.changePassword');
    Route::get('/update', 'AdminController@showChangeUserDetailsForm')->name('admin.changeUserDetailsForm');
    Route::post('/update', 'AdminController@changeUserDetails')->name('admin.changeUserDetails');
});

    