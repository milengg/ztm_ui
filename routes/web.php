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

// Panel
Route::group(['prefix' => 'panel','middleware' => ['auth']], function () {
    Route::get('main', [App\Http\Controllers\AdminController::class, 'main'])->name('admin.main');
    Route::get('logs', [App\Http\Controllers\AdminController::class, 'logs'])->name('admin.logs');
    Route::get('changelog', [App\Http\Controllers\AdminController::class, 'changelog'])->name('admin.changelog');
    
    //Settings
    Route::get('parameter/{id}', [App\Http\Controllers\AdminController::class, 'settings_edit'])->name('admin.edit.parameter');
    Route::post('parameter/update/{id}', [App\Http\Controllers\AdminController::class, 'settings_update'])->name('admin.update.parameter');

    //Under tests
    Route::get('qt', [App\Http\Controllers\AdminController::class, 'maintenance_mode'])->name('admin.qt');
    
    //Server&Tablet
    Route::get('updates', [App\Http\Controllers\AdminController::class, 'updates_settings'])->name('admin.updates.settings');
    Route::get('download/publickey/{id}', [App\Http\Controllers\AdminController::class, 'download_publickey'])->name('admin.download.publickey');
    Route::get('clients', [App\Http\Controllers\AdminController::class, 'clients'])->name('admin.clients');
    Route::get('clients/add', [App\Http\Controllers\AdminController::class, 'add_client'])->name('admin.clients.add');
    Route::get('clients/tablet/delete/{id}', [App\Http\Controllers\AdminController::class, 'delete_tablet'])->name('admin.clients.delete');
    Route::get('clients/server/delete/{id}', [App\Http\Controllers\AdminController::class, 'delete_server'])->name('admin.server.delete');
    Route::post('clients/create/server', [App\Http\Controllers\AdminController::class, 'create_server_settings'])->name('admin.clients.create.server');
    Route::post('clients/create/tablet', [App\Http\Controllers\AdminController::class, 'create_tablet_settings'])->name('admin.clients.create.tablet');
    Route::post('updates/store', [App\Http\Controllers\AdminController::class, 'updates_settins_store'])->name('admin.updates.settings.store');
    Route::post('updates/allow', [App\Http\Controllers\AdminController::class, 'updates_allowed'])->name('admin.updates.allow');
    
    //Tablet logout
    Route::post('logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
    
});


// Api
Route::group(['prefix' => 'data'], function () {
    Route::post('post', [App\Http\Controllers\DataController::class, 'registers'])->name('data');
});


