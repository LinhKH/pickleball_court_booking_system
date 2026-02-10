<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourtUnitSlot extends Model
{
  protected $fillable = [
    'court_unit_id',
    'date',
    'start_time',
    'end_time',
    'status',
  ];

  public function courtUnit(): BelongsTo
  {
    return $this->belongsTo(CourtUnit::class);
  }
}
