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
    Route::get('', 'StudentController@index')->name('student.dashboard');
    Route::get('/quiz/{quiz}', 'StudentController@show')->name('quiz.show');
    Route::get('/quiz/{quiz}/questions', 'StudentController@questions')->name('quiz.questions');
    Route::post('/quiz/{quiz}/results', 'StudentController@results')->name('quiz.results');
    //Authentication
    Route::get('/update/password', 'StudentController@showChangePasswordForm')->name('changeUserPasswordForm');;
    Route::post('/update/password', 'StudentController@changePassword')->name('changePassword');
    Route::get('/update', 'StudentController@showChangeUserDetailsForm')->name('changeUserDetailsForm');;
    Route::post('/update', 'StudentController@changeUserDetails')->name('changeUserDetails');
});

Route::prefix('teacher')->group(function() {
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    //Quiz
    Route::post('/create-quiz', 'QuizController@create')->name('quiz.create');
    Route::get('/edit-quiz/{quiz}', 'QuizController@edit')->name('quiz.editForm');
    Route::post('/edit-quiz/{quiz}', 'QuizController@store')->name('quiz.edit');
    Route::delete('/delete-quiz/{quiz}', 'QuizController@destroy')->name('quiz.delete');
    Route::post('/show-results/{quiz}', 'QuizController@show')->name('quiz.showResults');
    Route::post('/present-results/{quiz}', 'QuizController@present')->name('quiz.presentResults');
    Route::post('/present-results/{quiz}/data', 'QuizController@presentData')->name('quiz.presentResultsData');
    //Questions
    Route::get('/create-question/{quiz}', 'QuestionController@create')->name('question.create'); 
    Route::post('/create-question/{quiz}', 'QuestionController@store')->name('question.store');
    Route::get('/edit-quiz/{quiz}/question/{question}', 'QuestionController@edit')->name('question.editForm');
    Route::post('/edit-quiz/{quiz}/question/{question}', 'QuestionController@editStore')->name('question.edit');
    Route::delete('/delete-quiz/{quiz}/question/{question}', 'QuestionController@destroy')->name('question.delete');
    //Authentication
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/register', 'Auth\AdminRegisterController@showRegisterForm')->name('admin.register');
    Route::post('/register', 'Auth\AdminRegisterController@register')->name('admin.register.submit');
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::get('/update/password', 'AdminController@showChangePasswordForm')->name('admin.changePasswordForm');
    Route::post('/update/password', 'AdminController@changePassword')->name('admin.changePassword');
    Route::get('/update', 'AdminController@showChangeUserDetailsForm')->name('admin.changeUserDetailsForm');
    Route::post('/update', 'AdminController@changeUserDetails')->name('admin.changeUserDetails');
});

Route::fallback(function () {
    return response()->view('auth.notFound', [], 404);
});

    