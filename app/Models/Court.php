<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
  use HasFactory;
  protected $fillable = [
    'owner_id',
    'name',
    'description',
    'address',
    'lat',
    'lng',
    'open_time',
    'close_time',
    'status',
  ];

  public function slots()
  {
    return $this->hasMany(CourtSlot::class);
  }

  public function priceRules()
  {
    return $this->hasMany(CourtPriceRule::class);
  }

  public function units()
  {
    return $this->hasMany(CourtUnit::class);
  }
}
