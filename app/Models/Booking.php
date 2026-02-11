<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
  use HasFactory;
  protected $fillable = [
    'id',
    'user_id',
    'court_id',
    'court_unit_id',
    'total_price',
    'status',
  ];

  public function slots()
  {
    return $this->hasMany(BookingSlot::class);
  }
}
