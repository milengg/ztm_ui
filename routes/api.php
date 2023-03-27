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


// Updater   
Route::any('/sync_place', [UpdateController::class, 'syncPlace'])->name('api.sync-place');
Route::any('/version', [UpdateController::class, 'getVersion'])->name('api.version');
Route::any('/download', [UpdateController::class, 'downloadFiles'])->name('api.download');
Route::any('/ping', [UpdateController::class, 'receivePing'])->name('api.ping');
Route::any('/isservicealive', [UpdateController::class, 'isAlive'])->name('api.isalive');