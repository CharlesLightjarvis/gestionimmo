<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BienController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategorieBienController;
use App\Http\Controllers\SousCategorieBienController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->middleware('auth:sanctum')->group(function () {
    Route::resource('categories', CategorieBienController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('scategories', SousCategorieBienController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('biens', BienController::class);
});

Route::middleware('api')->group(function ($router) {
    Route::post('/createpayment', [PaymentController::class, 'createPaymentIntent']);
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);
