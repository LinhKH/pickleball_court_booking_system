<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Interfaces\Http\Controllers\BookingController;
use App\Interfaces\Http\Controllers\AvailabilityController;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {

  // Hold slot (giữ chỗ)
  Route::post('/slots/hold', [AvailabilityController::class, 'hold']);

  // Create booking
  Route::post('/bookings', [BookingController::class, 'store']);
});
