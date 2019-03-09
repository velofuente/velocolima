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

Route::get('/test', 'test@test');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user', function(){
    return view('user');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('instructors', 'InstructorController');

Route::get('/schedule', 'InstructorController@schedule');

// Route::get('/schedule', function(){
//     return view ('schedule');
// });

Route::get('/book', function(){
    return view('book');
});

Route::get('/bike-selection/{schedules}', 'InstructorController@bikeSelection');

Route::get('/first-visit', function (){
    return view('first-visit');
});

Auth::routes(['verify' => true]);

Route::resource('user', 'UserController');
