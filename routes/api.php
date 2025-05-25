<?php

use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TableController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/ping', function () {
    return response()->json(['pong' => true]);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function () {
    Route::post('login', [JWTAuthController::class, 'login']);
    Route::post('register-customer', [JWTAuthController::class, 'registerCustomer']);
    Route::post('register-admin', [JWTAuthController::class, 'registerAdmin']);
});

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('me', [JWTAuthController::class, 'getUser']);
    Route::post('logout', [JWTAuthController::class, 'logout']);

    Route::prefix('tables')->group(function () {
        Route::get('/', [TableController::class, 'index']);
        Route::post('/', [TableController::class, 'store']);
        Route::patch('/{id}', [TableController::class, 'update']);
        Route::delete('/{id}', [TableController::class, 'destroy']);
    });

    Route::prefix('reservations')->group(function () {
        Route::get('/', [ReservationController::class, 'index']);
        Route::post('/', [ReservationController::class, 'store']);
        Route::patch('/{id}/cancel', [ReservationController::class, 'cancelReservation']);
    });
});
