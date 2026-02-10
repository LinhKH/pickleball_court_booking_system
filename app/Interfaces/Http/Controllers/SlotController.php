<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\Availability\ListSlots;
use App\Application\Availability\ListSlotsCommand;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SlotController extends Controller
{
  public function index(
    int $court,
    Request $request,
    ListSlots $useCase
  ): JsonResponse {
    $date = $request->query('date');

    $slots = $useCase->execute(
      new ListSlotsCommand(
        courtId: $court,
        date: $date
      )
    );

    return response()->json([
      'court_id' => $court,
      'date'     => $date,
      'slots'    => $slots,
    ]);
  }
}
