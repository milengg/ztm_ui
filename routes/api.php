<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UpdateController;
use App\Http\Controllers\API\ValueController;

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

Route::controller(AuthController::class)->group(function() {
    Route::post('/login', 'login');
});

Route::middleware('auth:sanctum')->group(function() {
    Route::get('data/get', [ValueController::class, 'index']);
    Route::post('data/post', [ValueController::class, 'update']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Updater API
Route::any('/version', [UpdateController::class, 'getVersion'])->name('api.version');
Route::any('/ping', [UpdateController::class, 'receivePing'])->name('api.ping');