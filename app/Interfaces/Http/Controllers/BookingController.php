<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\Booking\CreateBooking;
use App\Application\Booking\CreateBookingCommand;
use App\Http\Controllers\Controller;
use App\Interfaces\Http\Requests\CreateBookingRequest;
use Illuminate\Http\JsonResponse;

/**
📌 Controller:
Không query DB
Không logic nghiệp vụ
Chỉ map HTTP → Command → Use Case
 */
class BookingController extends Controller
{
  public function store(
    CreateBookingRequest $request,
    CreateBooking $useCase
  ): JsonResponse {
    $booking = $useCase->execute(
      new CreateBookingCommand(
        userId: $request->user()->id,
        courtId: $request->court_id,
        courtUnitId: $request->court_unit_id,
        date: $request->date,
        slots: $request->slots
      )
    );

    return response()->json([
      'id'          => $booking->id,
      'status'      => $booking->status,
      'total_price' => $booking->total_price,
    ], 201);
  }
}
