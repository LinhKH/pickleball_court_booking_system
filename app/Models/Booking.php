<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
  protected $fillable = [
    'user_id',
    'court_id',
    'total_price',
    'status',
  ];

  public function slots()
  {
    return $this->hasMany(BookingSlot::class);
  }
}
