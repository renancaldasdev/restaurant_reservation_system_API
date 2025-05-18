<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/ping', function () {
    return response()->json(['pong' => true]);
});

Route::group([
    'middleware' => 'api',
    'prefix'     => 'users'
], function () {
    Route::post('login',    [JWTAuthController::class, 'login']);
    Route::post('register', [JWTAuthController::class, 'register']);
});

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('me',   [JWTAuthController::class, 'getUser']);
    Route::post('logout', [JWTAuthController::class, 'logout']);
});
