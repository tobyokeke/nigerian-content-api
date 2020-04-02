<?php

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


Route::group(['prefix' => 'v1'],function(){

//    Route::get('setup','UserController@setup')->name('users.setup');
//    Route::post('sign-up','UserController@signUp')->name('users.sign-up.post');
//    Route::post('sign-in','UserController@signIn')->name('users.sign-in.post');
//    Route::post('start-forgot-password','UserController@startForgotPassword');
//    Route::post('confirm-phone-code','UserController@confirmPhoneCode');
//    Route::post('finish-forgot-password','UserController@finishForgotPassword');

    Route::group(['middleware' => ['auth:api','scope:user']],function(){
//        Route::get('resend-phone-code','UserController@resendPhoneCode')->name('users.codes.resend.phone');
//        Route::post('resolve-account','UserController@resolveAccount')->name('users.account.resolve.post');

//        Route::get('profile','UserController@profile');
//        Route::post('change-password','UserController@changePassword');
//        Route::get('dashboard','UserController@dashboard');
//        Route::post('save-profile-photo','UserController@saveProfilePhoto');


        //        Route::get('start-add-card','UserController@startAddCard');
//        Route::post('finish-add-card','UserController@finishAddCard');
//        Route::post('make-account-default','UserController@makeAccountDefault');
//        Route::post('make-card-default','UserController@makeCardDefault');


//        Route::get('notifications','UserController@notifications');
//        Route::post('notification-details','UserController@notificationDetails');
//        Route::post('read-notification','UserController@readNotification');
//
//        Route::post('add-device-token','UserController@addDeviceToken');
    });

    Route::group(['prefix' => 'admin'], function(){
//        Route::get('setup','AdminController@setup');
//        Route::post('sign-in','AdminController@signIn');
//        Route::post('start-forgot-password','AdminController@startForgotPassword');
//        Route::post('finish-forgot-password','AdminController@finishForgotPassword');

        Route::group(['middleware' => ['auth:staff','scope:staff']],function(){
//            Route::post('add-staff','AdminController@addStaff');
//            Route::post('staff','AdminController@staff');
//            Route::post('staff-details','AdminController@staffDetails');
//            Route::post('dashboard','AdminController@dashboard');
//            Route::post('search','AdminController@search');
//            Route::post('users','AdminController@users');
//            Route::post('user-details','AdminController@userDetails');

        });
    });





});
