<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PurchaseController;
use Monolog\Handler\RotatingFileHandler;
use App\Http\Controllers\BookClassController;
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

Route::get('/emailTest', function () {
    return view('emails.birthday-free-class');
});

// Route::get('prueba', function () {
//     return view('prueba');
// });

Route::get('/', function () {
    if(Auth::check()){
        return redirect('/user');
    }
    return view('welcome');
});

Route::get('/client', function(){
    return view('client');
})->middleware('auth');

Route::get('/legales', function () {
    return view('legales');
});

Auth::routes();

Route::resource('instructors', 'InstructorController');
Route::get('/schedule', 'InstructorController@schedule');
// Route::get('/scheduleBackup', 'InstructorController@scheduleBackup');
Route::get('/branches', 'BranchesController@index');
Route::post('/sendMail', 'MailSendingController@coachInfo');
Route::post('/charge', 'PurchaseController@store');
//Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/register', 'UserController@store');
Route::get('/bike-selection/{schedules}', 'InstructorController@bikeSelection');

//siento qe va hacer un midd podría preguntarle a paul si le movió a algo de eso porque funcionaba perfectamente antes
// de echo le pregunte  me dijo que no le mv nada el mmmm entonces fue wil?
// Route::get('/addCard', 'OpenPayController@addCustomerCard');
// Route::get('/', 'HomeController@index');
// Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
Route::get('/home', 'HomeController@index')->name('home');
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
    // Route::get('admin', 'AdminController@index')->name('admin');
    Route::get('/admin', 'AdminController@index')->name('admin');
    // Show Pages (NEW STRUCTURE)
    Route::get('/admin/instructors', 'AdminController@showInstructors')->name('admin/instructors');
    Route::get('/admin/schedules', 'AdminController@showSchedules')->name('admin/schedules');
    Route::get('/admin/branches', 'AdminController@showBranches')->name('admin/branches');
    Route::get('/admin/products', 'AdminController@showProducts')->name('admin/products');
    Route::get('/admin/users', 'AdminController@showUsers')->name('admin/users');
    Route::get('/admin/clients', 'AdminController@showClients')->name('admin/clients');
    // Route::get('admin/operations/{$id}', 'AdminController@showOperationsGrid')->name('admin/operations');
    Route::get('/admin/operations/{selected_schedule}', 'AdminController@showOperationsGrid');
    Route::get('/admin/operations', 'AdminController@showOperationsGrid');
    Route::get('/admin/reports', 'AdminController@showReports')->name('admin/reports');
    // Show Pages (DEPRECATED)
    // Route::get('admin/operations', 'AdminController@showOperationsGrid')->name('admin/operations');
    // Route::get('admin-instructors', 'AdminController@showInstructors')->name('admin-instructors');
    // Route::get('admin-schedules', 'AdminController@showSchedules')->name('admin-schedules');
    // Route::get('admin-products', 'AdminController@showProducts')->name('admin-products');
    // Route::get('admin-branches', 'AdminController@showBranches')->name('admin-branches');
    // Route::get('admin-users', 'AdminController@showUsers')->name('admin-users');
    // Route::get('admin-clients', 'AdminController@showClients')->name('admin-clients');
    // Route::get('admin-sales', 'AdminController@showSales')->name('admin-sales');
    Route::post('/preRegister', 'BookClassController@preRegister');
    Route::post('/attendClass', 'BookClassController@attendClass');
    Route::post('/getNonScheduledUsers', 'AdminController@getNonScheduledUsers');
    Route::post('/getOperationBikes', 'AdminController@getOperationBikes');
    // Live Search Routes
    Route::get('/admin/sales', 'AdminController@showSales')->name('admin/sales');
    Route::get('/admin/sales/fetch_data', 'AdminController@fetch_data');
    Route::post('/admin/getUserInfo', 'AdminController@getUserInfo')->name('admin/getUserInfo');
    Route::post('/admin/getUserInfoReports', 'AdminController@getUserInfoReports')->name('admin/getUserInfoReports');
    Route::post('/admin/getReports', 'AdminController@getReports')->name('/admin/getReports');
    // End Live Search Routes
    Route::get('/admin-reports', 'AdminController@showReports')->name('admin-reports');
    Route::get('/admin-operations', 'AdminController@showOperationsGrid')->name('admin-operations');
    Route::get('/admin-sales/fetch_users', 'AdminController@fetch_users');
    Route::post('/showClientsTable', 'AdminController@showClientsTable');
    //Instructor
    Route::post('/addInstructor', 'AdminController@addInstructor');
    Route::post('/editInstructor', 'AdminController@editInstructor');
    Route::post('/deleteInstructor', 'AdminController@deleteInstructor');
    Route::post('/getInstructorSchedule', 'AdminController@getInstructorSchedule');
    //Horario
    Route::post('/addSchedule', 'AdminController@addSchedule');
    Route::post('/editSchedule', 'AdminController@editSchedule');
    Route::post('/deleteSchedule', 'AdminController@deleteSchedule');
    Route::get('/getNextClasses', 'AdminController@getNextClasses');
    Route::get('/getPreviousClasses', 'AdminController@getPreviousClasses');
    Route::post('/scheduledReservedPlaces', 'AdminController@scheduledReservedPlaces');
    Route::post('/absentUserClass', 'BookClassController@absentUserClass');
    Route::post('/cancelUserClass', 'BookClassController@cancelUserClass');
    //Sucursal
    Route::post('/addBranch', 'AdminController@addBranch');
    Route::post('/editBranch', 'AdminController@editBranch');
    Route::post('/deleteBranch', 'AdminController@deleteBranch');
    //Producto
    Route::post('/addProduct', 'AdminController@addProduct');
    Route::post('/editProduct', 'AdminController@editProduct');
    Route::post('/deleteProduct', 'AdminController@deleteProduct');
    Route::get('/products/{id}', 'ProductController@edit');

    Route::post('/addProduct', 'AdminController@addProduct');
    Route::post('/editProduct', 'AdminController@editProduct');
    Route::post('/deleteProduct', 'AdminController@deleteProduct');
    //Admin
    Route::post('/addUser', 'AdminController@addUser');
    Route::post('/editUser', 'AdminController@editUser');
    Route::post('/deleteUser', 'AdminController@deleteUser');
    //Ventas
    Route::post('/sale', 'AdminController@sale');
    //Clientes
    Route::post('/addClient', 'AdminController@addClient');
});

// Grupo de Middeleware para Usuarios Promedio
Route::group(['middleware' => ['auth','user.access']], function(){
    Route::post('/api/validatePackageReservation', 'BookClassController@validatePackageReservation');
    Route::get('/user', 'UserController@index')->name('user')->middleware('auth');
    Route::resource('/user', 'UserController');
    Route::patch('/user', 'UserController@updatePassword')->name('updatePassword');
    Route::post('/updateData', 'UserController@updateData');
    Route::post('/book', 'BookClassController@book');
    Route::post('/cancelClass', 'BookClassController@cancelClass');
    Route::post('/checkCancelLimit', 'BookClassController@checkCancelLimit');
    Route::post('/claimClass', 'BookClassController@claimClass');
    //OPENPAY
    //Route::get('user', 'UserController@getAuthenticatedUser');
    Route::post('/addCard','OpenPayController@addCustomerCard');
    Route::post('/makeCharge', 'OpenPayController@makeChargeCustomer');
    Route::post('/makeChargeCard', 'OpenPayController@makeChargeCard');
    Route::post('/deleteUserCard', 'CardController@deleteUserCard');
    Route::post('/getClient', 'OpenPayController@getCustomer');
    Route::post('/deleteClient', 'OpenPayController@deleteCustomer');
    Route::post('/walkInRegister', 'MailSendingController@walkInRegister');
});
