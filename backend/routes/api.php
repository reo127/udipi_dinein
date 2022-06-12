<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RestaurantAuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', [UserAuthController::class, 'login']);
Route::post('logout', [UserAuthController::class, 'logout']);
Route::post('menu-listing', [UserController::class, 'menuListing']);
Route::post('check-table-availability', [UserController::class, 'checkTableAvailability']);
Route::post('place-order', [UserController::class, 'placeOrder']);
Route::post('order-listing', [UserController::class, 'orderList']);


//restaurants routes
Route::post('restaurant/login', [RestaurantAuthController::class, 'login']);
Route::post('restaurant/logout', [RestaurantAuthController::class, 'logout']);
Route::post('restaurant/add-table', [RestaurantController::class, 'addTable']);
Route::post('restaurant/delete-table', [RestaurantController::class, 'deleteTable']);
Route::post('restaurant/list-table', [RestaurantController::class, 'listTabel']);
