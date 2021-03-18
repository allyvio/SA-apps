<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');

Route::post('/password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
Route::post('/password/reset', 'Api\ResetPasswordController@reset');


Route::get('/email/resend', 'Api\VerificationController@resend')->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', 'Api\VerificationController@verify')->name('verification.verify');

//event-management
Route::get('/event-list', 'Api\EventController@guestEvent')->middleware('auth:api');
Route::get('/userHasEvent', 'Api\EventController@userHasEvent')->middleware('auth:api');
Route::get('/eventHasUser/{id}', 'Api\EventController@eventHasUser')->middleware('auth:api');
Route::get('/userEventStatus/{id}', 'Api\EventController@userEventStatus')->middleware('auth:api');
Route::post('/userRegisterEvent', 'Api\EventController@userRegisterEvent')->middleware('auth:api');
Route::get('/checkUserRegistered/{event_id}', 'Api\EventController@checkUserRegistered')->middleware('auth:api');
Route::get('/event-detail/{id}', 'Api\EventController@getEventById');


//present
Route::get('/getCode/{code}', 'Api\EventController@getCode')->middleware('auth:api');
Route::get('/postPresent/{id}', 'Api\EventController@postPresent')->middleware('auth:api');


//user-management
Route::get('/profile', 'Api\UserController@show')->middleware('auth:api');
