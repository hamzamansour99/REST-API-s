<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\OwnerCarPoolingController;
use App\Http\Controllers\Api\UserCarPoolingController;
use App\Http\Controllers\Api\ChatingController;




 
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('save', [CarController::class, 'save']);
Route::post('Contact-Us', [ContactUsController::class, 'Contact']);

 
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('user-details/{id}', [UserController::class, 'userDetails']);
    Route::put('user-Update/{id}', [UserController::class, 'UpdateUser']);
    Route::put('Change-Password/{id}', [UserController::class, 'ChangePassword']);
    Route::post('Logout', [UserController::class, 'logout']);

    Route::put('car-Update/{car_id}', [CarController::class, 'UpdateCar']);
    Route::get('Active-Cars/{user_id}', [CarController::class, 'ActiveCars']);

    Route::post('Add-OwnerCarPooling', [OwnerCarPoolingController::class, 'AddCarPooling']);
    Route::get('Get-OwnerCarPooling/{id}', [OwnerCarPoolingController::class, 'GetOwnerCarPooling']);
    Route::put('OwnerCarPooling-Update/{pooling_id}', [OwnerCarPoolingController::class, 'UpdateOwnerCarPooling']);
    Route::delete('OwnerCarPooling-Delete/{pooling_id}', [OwnerCarPoolingController::class, 'DeleteOwnerCarPooling']);

    Route::post('Add-UserCarPooling', [UserCarPoolingController::class, 'AddCarPooling']);
    Route::get('Get-UserCarPooling/{id}', [UserCarPoolingController::class, 'GetUserCarPooling']);
    Route::put('UserCarPooling-Update/{pooling_id}', [UserCarPoolingController::class, 'UpdateUserCarPooling']);
    Route::delete('UserCarPooling-Delete/{pooling_id}', [UserCarPoolingController::class, 'DeleteUserCarPooling']);

    Route::post('PostId', [ChatingController::class, 'PostId']);
    Route::post('message', [ChatingController::class, 'message']);
    Route::get('Get-Chat/{id}', [ChatingController::class, 'GetChat']);
    


});