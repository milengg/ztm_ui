<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\PageController::class, 'index'])->name('welcome');

// Admin
Route::group(['prefix' => 'auth'], function () {
    Route::post('unlock', [App\Http\Controllers\AdminController::class, 'unlockPin']);
});
Route::group(['prefix' => 'auth','middleware' => ['auth']], function () {
    Route::get('main', [App\Http\Controllers\AdminController::class, 'settings'])->name('admin.index');
    Route::get('parameter/{id}', [App\Http\Controllers\AdminController::class, 'settings_edit'])->name('admin.edit.parameter');
    Route::get('logs', [App\Http\Controllers\AdminController::class, 'logs'])->name('admin.logs');
    Route::get('qt', [App\Http\Controllers\AdminController::class, 'runQt'])->name('admin.qt');
    Route::get('changelog', [App\Http\Controllers\AdminController::class, 'changelog'])->name('admin.changelog');
    Route::get('clients', [App\Http\Controllers\AdminController::class, 'clients'])->name('admin.clients');
    Route::post('logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
    Route::post('parameter/update/{id}', [App\Http\Controllers\AdminController::class, 'settings_update'])->name('admin.update.parameter');
});


// Api
Route::group(['prefix' => 'data'], function () {
    Route::post('post', [App\Http\Controllers\DataController::class, 'registers'])->name('data');
});


