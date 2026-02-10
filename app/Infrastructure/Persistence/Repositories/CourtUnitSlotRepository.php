<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Models\CourtUnitSlot;
use Illuminate\Support\Collection;

class CourtUnitSlotRepository
{
  public function getByCourtAndDate(int $courtId, string $date): Collection
  {
    return CourtUnitSlot::query()
      ->whereHas('courtUnit', fn($q) => $q->where('court_id', $courtId))
      ->where('date', $date)
      ->with('courtUnit')
      ->orderBy('start_time')
      ->get();
  }
}
