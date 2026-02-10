<?php

namespace App\Domain\Booking;

final class Booking
{
  private BookingStatus $status;
  private int $totalPrice = 0;

  public function __construct(
    private int $userId,
    private int $courtId
  ) {
    $this->status = BookingStatus::Pending;
  }

  public function addSlot(int $price): void
  {
    if ($this->status !== BookingStatus::Pending) {
      throw new BookingException('Cannot add slot to non-pending booking');
    }

    $this->totalPrice += $price;
  }

  public function markPaid(): void
  {
    if ($this->status !== BookingStatus::Pending) {
      throw new BookingException('Only pending booking can be paid');
    }

    $this->status = BookingStatus::Paid;
  }

  public function cancel(): void
  {
    if ($this->status === BookingStatus::Paid) {
      throw new BookingException('Paid booking cannot be cancelled directly');
    }

    $this->status = BookingStatus::Cancelled;
  }

  // 👉 expose read-only
  public function status(): BookingStatus
  {
    return $this->status;
  }

  public function totalPrice(): int
  {
    return $this->totalPrice;
  }

  public function userId(): int
  {
    return $this->userId;
  }

  public function courtId(): int
  {
    return $this->courtId;
  }
}
