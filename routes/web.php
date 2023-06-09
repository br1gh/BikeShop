<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helper\TableController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('layouts.app');
    });

    Route::name('bikes.')
        ->prefix('bikes')
        ->group(function () {
            Route::get('/', [BikeController::class, 'index'])->name('index');
            Route::match(['get', 'post'], '/edit/{id?}', [BikeController::class, 'edit'])->name('edit');
            Route::get('/delete/{id}', [BikeController::class, 'delete'])->name('delete');
        });

    Route::name('parts.')
        ->prefix('parts')
        ->group(function () {
            Route::get('/', [PartController::class, 'index'])->name('index');
            Route::match(['get', 'post'], '/edit/{id?}', [PartController::class, 'edit'])->name('edit');
            Route::get('/delete/{id}', [PartController::class, 'delete'])->name('delete');
        });

    Route::name('accessories.')
        ->prefix('accessories')
        ->group(function () {
            Route::get('/', [AccessoryController::class, 'index'])->name('index');
            Route::match(['get', 'post'], '/edit/{id?}', [AccessoryController::class, 'edit'])->name('edit');
            Route::get('/delete/{id}', [AccessoryController::class, 'delete'])->name('delete');
        });

    Route::name('parameters.')
        ->prefix('parameters')
        ->group(function () {
            Route::get('/', [ParameterController::class, 'index'])->name('index');
            Route::match(['get', 'post'], '/edit/{id?}', [ParameterController::class, 'edit'])->name('edit');
            Route::get('/delete/{id}', [ParameterController::class, 'delete'])->name('delete');
        });

    Route::post('/table/fetch/{tableName}', [TableController::class, 'fetch'])->name('table.fetch');
});

Route::middleware('auth.superadmin')
    ->group(function () {
        Route::name('users.')
            ->prefix('users')
            ->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::match(['get', 'post'], '/edit/{id?}', [UserController::class, 'edit'])->name('edit');
                Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
            });
    });
