<?php

use Illuminate\Http\Request;
use App\Http\Controllers\OpenPayController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'UserController@store');
Route::post('login', 'UserController@authenticate');
Route::post('getClient', 'OpenPayController@getCustomer');
Route::post('deleteClient', 'OpenPayController@deleteCustomer');

Route::group(['middleware' => ['jwt.verify', 'cors']], function() {
    Route::post('addCard','OpenPayController@addCustomerCard');
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::post('makeCharge', 'OpenPayController@makeChargeCustomer');
});
