<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\WeatherController;


Route::prefix('check')->group(function () {
    Route::get('/humidity', [WeatherController::class, 'checkHumidity']);
    Route::get('/pressure', [WeatherController::class, 'checkPressure']);
});

