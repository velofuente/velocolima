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

// Route::get('/test', 'test@test');

// Route::get('/123', function () {
//     return 1;
// });

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

<<<<<<< HEAD
//Ruta a Página "Instructores"
Route::get('/instructors', function(){
    return view('instructors');
=======
Route::get('/instructor-info', function () {
    return view('instructor-info');
>>>>>>> Avance pagina info-instructors con imagen, nombre y descripcion
});