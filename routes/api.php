<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function ($router) {
    Route::get('/items', [ProductController::class, 'index']);
    Route::post('/item/add', [ProductController::class, 'store']);
    Route::post('/item/update', [ProductController::class, 'update']);
    Route::post('/item/delete', [ProductController::class, 'destroy']);
    Route::post('/item/search', [ProductController::class, 'searchBySku']);

});