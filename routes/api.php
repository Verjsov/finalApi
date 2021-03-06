<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/weather/{code}', [\App\Http\Controllers\WeatherController::class, 'fetch'])->name('weather.get');
Route::get('/list', [\App\Http\Controllers\WeatherController::class, 'list'])->name('weather.list');
Route::post('/add/favorite/{code}', [\App\Http\Controllers\WeatherController::class, 'addFavorite'])->name('weather.favorite');
