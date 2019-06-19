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

Route::get('prueba', function () {
    return view('prueba');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/client', function(){
    return view('client');
})->middleware('auth');

Auth::routes(['verify' => true]);
Route::resource('instructors', 'InstructorController');
Route::get('/schedule', 'InstructorController@schedule');
Route::get('/branches', 'BranchesController@index');
Route::post('sendMail', 'MailSendingController@coachInfo');
Route::post('charge', 'PurchaseController@store');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('register', 'UserController@store');

// Route::get('/addCard', 'OpenPayController@addCustomerCard');
// Route::get('/', 'HomeController@index');
// Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('test', 'UserController@test');

// Route::get('/schedule', function(){
//     return view ('schedule');
// });

// Route::get('/book', function(){
//     return view('book');
// });

// Route::get('/who-are-we', function(){
//     return view('who-are-we');
// });

// Route::get('/first-visit', function (){
//     return view('first-visit');
// });

// Grupo de Middleware para Administradores
Route::group(['middleware' => ['auth','admin.access']], function(){
    // Admin Index
    Route::get('admin', 'AdminController@index')->name('admin');
    // Show Pages
    Route::get('admin-instructors', 'AdminController@showInstructors')->name('admin-instructors');
    Route::get('admin-schedules', 'AdminController@showSchedules')->name('admin-schedules');
    Route::get('admin-products', 'AdminController@showProducts')->name('admin-products');
    Route::get('admin-branches', 'AdminController@showBranches')->name('admin-branches');
    Route::get('admin-users', 'AdminController@showUsers')->name('admin-users');
    Route::get('admin-clients', 'AdminController@showClients')->name('admin-clients');
    // Route::get('admin-sales', 'AdminController@showSales')->name('admin-sales');

    // Live Search Routes
    Route::get('/admin-sales', 'AdminController@showSales')->name('admin-sales');
    Route::get('/admin-sales/fetch_data', 'AdminController@fetch_data');
    // End Live Search Routes
    Route::get('admin-reports', 'AdminController@showReports')->name('admin-reports');
    Route::get('admin-operations', 'AdminController@showOperationsGrid')->name('admin-operations');
    //Instructor
    Route::post('addInstructor', 'AdminController@addInstructor');
    Route::post('editInstructor', 'AdminController@editInstructor');
    Route::post('deleteInstructor', 'AdminController@deleteInstructor');
    //Horario
    Route::post('addSchedule', 'AdminController@addSchedule');
    Route::post('editSchedule', 'AdminController@editSchedule');
    Route::post('deleteSchedule', 'AdminController@deleteSchedule');
    //Lugar
    Route::post('addBranch', 'AdminController@addBranch');
    Route::post('editBranch', 'AdminController@editBranch');
    Route::post('deleteBranch', 'AdminController@deleteBranch');
    //Producto
    Route::post('addProduct', 'AdminController@addProduct');
    Route::post('editProduct', 'AdminController@editProduct');
    Route::post('deleteProduct', 'AdminController@deleteProduct');
    //Admin
    Route::post('addUser', 'AdminController@addUser');
    Route::post('editUser', 'AdminController@editUser');
    Route::post('deleteUser', 'AdminController@deleteUser');
    //Ventas
    Route::post('sale', 'AdminController@sale');
});

// Grupo de Middeleware para Usuarios Promedio
Route::group(['middleware' => ['auth','user.access']], function(){
    Route::get('user', 'UserController@index')->name('user')->middleware('auth');
    Route::get('/bike-selection/{schedules}', 'InstructorController@bikeSelection');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    Route::resource('user', 'UserController');
    Route::patch('user', 'UserController@updatePassword')->name('updatePassword');
    Route::post('updateData', 'UserController@updateData');
    Route::post('book', 'BookClassController@book');
    Route::post('cancelClass', 'BookClassController@cancelClass');
    Route::post('attendClass', 'BookClassController@attendClass');
    Route::post('claimClass', 'BookClassController@claimClass');
    Route::post('preRegister', 'BookClassController@preRegister');
    //OPENPAY
    //Route::get('user', 'UserController@getAuthenticatedUser');
    Route::post('/addCard','OpenPayController@addCustomerCard');
    Route::post('makeCharge', 'OpenPayController@makeChargeCustomer');
    Route::post('makeChargeCard', 'OpenPayController@makeChargeCard');
    Route::post('getClient', 'OpenPayController@getCustomer');
    Route::post('deleteClient', 'OpenPayController@deleteCustomer');
    Route::post('walkInRegister', 'MailSendingController@walkInRegister');
});
