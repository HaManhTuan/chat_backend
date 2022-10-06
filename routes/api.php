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

// Category
Route::group(['middleware' => 'jwt.authenticate', 'prefix' => 'category'], function() {
    Route::get('list', [\App\Http\Controllers\CategoryController::class, 'getCategory']);
    Route::post('create', [\App\Http\Controllers\CategoryController::class, 'createCategory']);
    Route::put('edit/{id}', [\App\Http\Controllers\CategoryController::class, 'editCategory']);
    Route::post('delete/{id}', [\App\Http\Controllers\CategoryController::class, 'deleteCategory']);
});

// Product
Route::group(['middleware' => 'jwt.authenticate', 'prefix' => 'product'], function() {
    Route::get('list', [\App\Http\Controllers\ProductController::class, 'getProduct']);
    Route::post('create', [\App\Http\Controllers\ProductController::class, 'createProduct']);
    Route::put('edit/{id}', [\App\Http\Controllers\ProductController::class, 'editProduct']);
    Route::post('delete/{id}', [\App\Http\Controllers\ProductController::class, 'deleteProduct']);
});



//Frontend
Route::group(['prefix' => 'fe'], function() {
    Route::post('register', [AuthController::class, 'registerFe']);
    Route::post('login', [CustomerController::class, 'loginFe']);
    // Client-Customer
    Route::group(['prefix' => 'customer'], function() {
        Route::post('create-customer', [CustomerController::class, 'createCustomerFE']);
        Route::get('current-customer', [CustomerController::class, 'details'])->middleware('jwt.customers');
        Route::put('update-customer/{id}', [CustomerController::class, 'updateCustomer'])->middleware('jwt.customers');
        Route::post('logout', [CustomerController::class, 'loginFe']);
    });
});





