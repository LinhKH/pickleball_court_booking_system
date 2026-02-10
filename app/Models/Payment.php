<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  protected $fillable = [
    'booking_id',
    'provider',
    'amount',
    'status',
    'transaction_id',
    'paid_at',
  ];
}
