<?php

use App\Http\Controllers\Api\AvailabilityController as ApiAvailabilityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Interfaces\Http\Controllers\BookingController;
use App\Interfaces\Http\Controllers\AvailabilityController;
use App\Interfaces\Http\Controllers\SlotController;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {

  // Hold slot (giữ chỗ)
  Route::post('/slots/hold', [AvailabilityController::class, 'hold']);

  // Create booking
  Route::post('/bookings', [BookingController::class, 'store']);
});

Route::get('/courts/{court}/slots', [SlotController::class, 'index']);

Route::get('/courts/{court}/availability', [AvailabilityController::class, 'index']);

Route::get('/v1/availability', [ApiAvailabilityController::class, 'index']);
