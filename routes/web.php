<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PurchaseController;

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
// Route::get('/addCard', 'OpenPayController@addCustomerCard');
Route::get('/', function () {
    return view('welcome');
});    
//Route::get('/', 'HomeController@index');

// Route::get('/', 'HomeController@index');
Route::get('/', function(){
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('user', 'UserController@index')->name('user');

// Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
Route::post('register', 'UserController@store');

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('instructors', 'InstructorController');

Route::get('/schedule', 'InstructorController@schedule');

// Route::get('/schedule', function(){
//     return view ('schedule');
// });

Route::get('/book', function(){
    return view('book');
});

Route::get('/who-are-we', function(){
    return view('who-are-we');
});

Route::get('/bike-selection/{schedules}', 'InstructorController@bikeSelection');

Route::get('/first-visit', function (){
    return view('first-visit');
});

Route::post('charge', 'PurchaseController@store');

Route::resource('user', 'UserController');

Route::post('login', 'Auth\LoginController@login')->name('login');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::patch('user', 'UserController@updatePassword')->name('updatePassword');
//Route::get('test', 'UserController@test');

Route::get('/client', function(){
    return view('client');
})->middleware('auth');

//OPENPAY
//Route::get('user', 'UserController@getAuthenticatedUser');
Route::post('/addCard','OpenPayController@addCustomerCard');
Route::post('makeCharge', 'OpenPayController@makeChargeCustomer');
Route::post('getClient', 'OpenPayController@getCustomer');
Route::post('deleteClient', 'OpenPayController@deleteCustomer');