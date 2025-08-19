<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
Route::group(['prefix' => 'auth','namespace'=>'API'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
});
Route::get('events', 'API\EventController@index');
Route::get('events/{id}', 'API\EventController@show');

Route::middleware('jwt.auth')->group(function () {
    Route::post('/bookings', 'API\BookingController@store');
    Route::get('/myBookings', 'API\BookingController@myBookings');
});
Route::middleware('jwt.auth', 'role:admin')->group(function () {
    Route::post('/events', 'API\EventController@store');
    Route::put('/events/{id}', 'API\EventController@update');
    Route::delete('/events/{id}', 'API\EventController@destroy');
});
