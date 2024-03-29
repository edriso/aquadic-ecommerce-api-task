<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\OrderController;

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

Route::group(
    ['prefix' => 'v1', 'middleware' => 'auth:sanctum'],
    function () {
        Route::apiResource('orders', OrderController::class)
            ->only('index', 'store', 'show');
    }
);