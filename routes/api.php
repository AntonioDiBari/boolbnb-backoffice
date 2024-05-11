<?php

use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\MessageController;
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

Route::apiResource('apartments', ApartmentController::class)->only('index', 'show');
Route::get('apartment-sponsor', [ApartmentController::class, 'indexSponsor']);
Route::get('apartment-service', [ApartmentController::class, 'services']);
Route::post('message/{apartment}',[ MessageController::class, 'store' ]);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});