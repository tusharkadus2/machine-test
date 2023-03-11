<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CategoryController, MaterialController, QuantityController};

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

Route::view('/', 'dashboard.index')->name('dashboard');

// using resource route to create index, create, store, show, edit, update, destroy routes
Route::resource('categories', CategoryController::class);

Route::resource('materials', MaterialController::class);
Route::post('materials/{id}/restore', [MaterialController::class, 'restore'])->name('materials.restore');

Route::resource('quantities', QuantityController::class)->only(['create', 'store']);

Route::get('material-quantities', [QuantityController::class, 'manage'])->name('material.quantities.index');