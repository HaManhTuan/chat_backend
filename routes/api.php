<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TripCarStaffController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\TypeCarController;
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
Route::get('/', function () {
    return 'OK API';
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => 'jwt.authenticate', 'prefix' => 'auth'], function() {
    Route::get('current-user', [AuthController::class, 'details']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Staff
Route::group(['middleware' => 'jwt.authenticate', 'prefix' => 'staff'], function() {
    Route::get('list', [StaffController::class, 'getStaff']);
    Route::get('list-assistant-driver/{id}', [StaffController::class, 'getAssistantDriver']);
    Route::post('create', [StaffController::class, 'createStaff']);
    Route::put('edit/{id}', [StaffController::class, 'editStaff']);
    Route::post('delete/{id}', [StaffController::class, 'deleteStaff']);
});

// Customer
Route::group(['middleware' => 'jwt.authenticate', 'prefix' => 'customer'], function() {
    Route::get('list', [CustomerController::class, 'getCustomer']);
    Route::post('create', [CustomerController::class, 'createCustomerBE']);
    Route::put('edit/{id}', [CustomerController::class, 'editCustomerBE']);
    Route::post('delete/{id}', [CustomerController::class, 'deleteCustomer']);
});

// Type-Car
Route::group(['middleware' => 'jwt.authenticate', 'prefix' => 'type-car'], function() {
    Route::get('list', [TypeCarController::class, 'getTypeCar']);
    Route::post('create', [TypeCarController::class, 'createTypeCar']);
    Route::put('edit/{id}', [TypeCarController::class, 'editTypeCar']);
    Route::post('delete/{id}', [TypeCarController::class, 'deleteTypeCar']);
});

// Car
Route::group(['middleware' => 'jwt.authenticate', 'prefix' => 'car'], function() {
    Route::get('list', [CarController::class, 'getCar']);
    Route::post('create', [CarController::class, 'createCar']);
    Route::put('edit/{id}', [CarController::class, 'editCar']);
    Route::post('delete/{id}', [CarController::class, 'deleteCar']);
});

// Trip
Route::group(['middleware' => 'jwt.authenticate', 'prefix' => 'trip'], function() {
    Route::get('list', [TripController::class, 'getTrip']);
    Route::post('create', [TripController::class, 'createTrip']);
    Route::put('edit/{id}', [TripController::class, 'editTrip']);
    Route::post('delete/{id}', [TripController::class, 'deleteTrip']);
});

// TripStaffCar
Route::group(['middleware' => 'jwt.authenticate', 'prefix' => 'trip-staff-car'], function() {
    Route::get('list', [TripCarStaffController::class, 'getList']);
    Route::post('create', [TripCarStaffController::class, 'createData']);
//    Route::put('edit/{id}', [TripController::class, 'editTrip']);
//    Route::post('delete/{id}', [TripController::class, 'deleteTrip']);
});

//Schedules
Route::group(['middleware' => 'jwt.authenticate', 'prefix' => 'schedule'], function() {
    Route::get('list', [ScheduleController::class, 'getData']);
    Route::post('create', [ScheduleController::class, 'createData']);
    Route::put('edit/{id}', [ScheduleController::class, 'editData']);
    Route::delete('delete/{id}', [ScheduleController::class, 'deleteData']);
});

//Bookings
Route::group(['middleware' => 'jwt.authenticate', 'prefix' => 'booking'], function() {
    Route::post('create', [\App\Http\Controllers\BookingController::class, 'booking']);
});





// Client-Customer
Route::group(['prefix' => 'customer'], function() {
    Route::post('create-customer', [CustomerController::class, 'createCustomer']);
    Route::put('edit-customer/{id}', [CustomerController::class, 'editCustomer']);
});



