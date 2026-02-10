<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\Availability\HoldSlot;
use App\Application\Availability\HoldSlotCommand;
use App\Http\Controllers\Controller;
use App\Interfaces\Http\Requests\HoldSlotRequest;
use Illuminate\Http\JsonResponse;

use App\Application\Availability\ListAvailabilityByTime;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
  public function index(
    int $court,
    Request $request,
    ListAvailabilityByTime $useCase
  ): JsonResponse {
    $date = $request->query('date');

    $timeSlots = $useCase->execute($court, $date);

    return response()->json([
      'court_id'  => $court,
      'date'      => $date,
      'time_slots' => $timeSlots,
    ]);
  }
  public function hold(
    HoldSlotRequest $request,
    HoldSlot $useCase
  ): JsonResponse {
    $useCase->execute(
      new HoldSlotCommand(
        courtUnitId: $request->court_unit_id,
        date: $request->date,
        startTime: $request->start_time,
        userId: $request->user()->id
      )
    );

    return response()->json([
      'message' => 'Slot locked successfully',
    ]);
  }
}
