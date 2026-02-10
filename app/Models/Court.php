<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
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
