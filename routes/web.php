<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteLocationController;


Route::get('/', function () {
    return redirect()->route('weather.index');
});

Route::get('/weather', [WeatherController::class, 'index'])->name('weather.index');
Route::get('/add-location', [WeatherController::class, 'showAddLocation'])->name('show.add.location');

Route::post('/save-favorite', [WeatherController::class, 'saveFavorite'])->name('save.favorite');

Route::post('/favorite-locations', [FavoriteLocationController::class, 'store'])->name('favorite-locations.store');
Route::put('/favorite-locations/{location}', [FavoriteLocationController::class, 'update'])->name('favorite-locations.update');
Route::delete('/favorite-locations/{location}', [FavoriteLocationController::class, 'destroy'])->name('favorite-locations.destroy');

Route::get('/weather/current-location', [WeatherController::class, 'currentLocation'])->name('weather.current-location');
