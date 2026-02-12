<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetAvailabilityRequest;
use App\Application\Availability\GetAvailability;
use App\Application\Availability\GetAvailabilityCommand;

class AvailabilityController extends Controller
{
  public function index(
    GetAvailabilityRequest $request,
    GetAvailability $useCase
  ) {
    $data = $useCase->execute(
      new GetAvailabilityCommand(
        courtId: (int) $request->court_id,
        date: $request->date
      )
    );

    return response()->json($data);
  }
}
