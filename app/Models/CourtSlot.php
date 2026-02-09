<?php

use Illuminate\Database\Eloquent\Model;

class CourtSlot extends Model
{
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
}
