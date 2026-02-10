<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourtUnit extends Model
{
  protected $fillable = [
    'court_id',
    'name',
    'status',
  ];

  public function court(): BelongsTo
  {
    return $this->belongsTo(Court::class);
  }

  public function slots(): HasMany
  {
    return $this->hasMany(CourtUnitSlot::class);
  }
}
