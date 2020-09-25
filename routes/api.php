<?php

use App\Http\Controllers\Api\CarController;
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


Route::get('cars', [CarController::class, 'index'])->name('cars');
Route::get('cars/{car}', [CarController::class, 'show'])->name('car.show');
Route::put('cars/{car}', [CarController::class, 'update'])->name('car.update');
Route::delete('cars/{car}', [CarController::class, 'remove'])->name('car.remove');
Route::post('cars', [CarController::class, 'create'])->name('car.create');

Route::get('search', [CarController::class, 'search'])->name('cars.search');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
