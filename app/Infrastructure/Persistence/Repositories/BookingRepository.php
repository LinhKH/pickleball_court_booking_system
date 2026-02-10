<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Booking\Booking;
use App\Models\Booking as BookingModel;

//📌 Repository = map Domain → DB
class BookingRepository
{
  public function save(Booking $booking): BookingModel
  {
    return BookingModel::create([
      'user_id'       => $booking->userId(),
      'court_id'      => $booking->courtId(),
      'court_unit_id' => $booking->courtUnitId(),
      'total_price'   => $booking->totalPrice(),
      'status'        => $booking->status()->value,
    ]);
  }
}
