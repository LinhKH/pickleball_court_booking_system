<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BookingSlot extends Model
{
  protected $fillable = [
    'booking_id',
    'court_slot_id',
    'price',
  ];
}
