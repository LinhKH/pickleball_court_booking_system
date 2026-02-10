<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\Availability\HoldSlot;
use App\Application\Availability\HoldSlotCommand;
use App\Http\Controllers\Controller;
use App\Interfaces\Http\Requests\HoldSlotRequest;
use Illuminate\Http\JsonResponse;

class AvailabilityController extends Controller
{
  public function hold(
    HoldSlotRequest $request,
    HoldSlot $useCase
  ): JsonResponse {
    $useCase->execute(
      new HoldSlotCommand(
        courtId: $request->court_id,
        slotId: $request->slot_id,
        userId: $request->user()->id
      )
    );

    return response()->json([
      'message' => 'Slot locked successfully',
    ]);
  }
}
