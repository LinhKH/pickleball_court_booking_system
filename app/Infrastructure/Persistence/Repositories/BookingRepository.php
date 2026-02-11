<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Booking\Booking;
use App\Domain\Booking\BookingStatus;
use App\Models\Booking as BookingModel;
use App\Models\BookingSlot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class BookingRepository
{
  /* ============================================================
     | CREATE / SAVE
     ============================================================ */

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

    /* ============================================================
     | LOAD DOMAIN
     ============================================================ */

  /**
   * Load Booking Domain Entity
   */
  public function findDomain(int $bookingId): Booking
  {
    $model = BookingModel::findOrFail($bookingId);

    $booking = new Booking(
      userId: $model->user_id,
      courtId: $model->court_id,
      courtUnitId: $model->court_unit_id
    );

    // sync state
    $this->syncStatus($booking, $model->status);

    // sync price
    $this->syncTotalPrice($booking, (int) $model->total_price);

    return $booking;
  }

  /* ============================================================
     | UPDATE
     ============================================================ */

  public function updateStatus(Booking $booking): void
  {
    BookingModel::where('id', $booking->id())
      ->update([
        'status' => $booking->status()->value,
      ]);
  }

    /* ============================================================
     | BOOKING SLOTS
     ============================================================ */

  /**
   * Get slots of a booking (for Redis release)
   */
  public function getSlots(int $bookingId): Collection
  {
    return BookingSlot::query()
      ->where('booking_id', $bookingId)
      ->get([
        'court_unit_id',
        'date',
        'start_time',
      ]);
  }

    /* ============================================================
     | EXPIRE
     ============================================================ */

  /**
   * Get pending bookings that should be expired
   */
  public function getExpiredPending(): Collection
  {
    $expireBefore = Carbon::now()->subMinutes(5);

    return BookingModel::query()
      ->where('status', BookingStatus::Pending->value)
      ->where('created_at', '<=', $expireBefore)
      ->get();
  }

  /* ============================================================
     | INTERNAL HELPERS (DDD-LITE)
     ============================================================ */

  private function syncStatus(Booking $booking, string $status): void
  {
    match ($status) {
      BookingStatus::Pending->value   => null,
      BookingStatus::Paid->value      => $booking->markPaid(),
      BookingStatus::Cancelled->value => $booking->cancel(),
      BookingStatus::Expired->value   => $booking->expire(),
      default => null,
    };
  }

  private function syncTotalPrice(Booking $booking, int $totalPrice): void
  {
    // trick DDD-lite: replay state
    $reflection = new \ReflectionClass($booking);
    $property = $reflection->getProperty('totalPrice');
    $property->setAccessible(true);
    $property->setValue($booking, $totalPrice);
  }
}
