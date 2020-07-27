<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'QuestionsController@index');

Auth::routes();

Route::get('/home', 'QuestionsController@index')->name('home');

Route::get('/test', function (){
    $r = \App\Question::where('id', 4)->first();
    dd($r);
});

Route::resource('questions', 'QuestionsController')->except('show');//to make show route to use slug
Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');
Route::resource('questions.answers', 'AnswersController')->except('index', 'create', 'show');
//Route::post('questions/{question}/answers', 'AnswersController@store')->name('answers.store');
Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');

//test route for pdf creation
Route::get('/questions_to_pdf', 'PDFController@generatePDF');

//favorite question
Route::post('/questions/{question}/favorites', 'FavoritesController@store')->name('questions.favorite');
Route::delete('/questions/{question}/favorites', 'FavoritesController@destroy')->name('questions.unfavorite');

//vote
Route::post('/questions/{question}/vote', 'VoteQuestionController');
Route::post('/answers/{answer}/vote', 'VoteAnswerController');
