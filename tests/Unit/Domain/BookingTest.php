<?php

namespace Tests\Unit\Domain;

use App\Domain\Booking\Booking;
use App\Domain\Booking\BookingException;
use PHPUnit\Framework\TestCase;

class BookingTest extends TestCase
{
  public function test_booking_starts_as_pending(): void
  {
    $booking = new Booking(1, 1, 1);

    $this->assertEquals('pending', $booking->status()->value);
    $this->assertEquals(0, $booking->totalPrice());
  }

  public function test_can_add_slot_price(): void
  {
    $booking = new Booking(1, 1, 1);
    $booking->addSlot(200_000);

    $this->assertEquals(200_000, $booking->totalPrice());
  }

  public function test_can_mark_booking_as_paid(): void
  {
    $booking = new Booking(1, 1, 1);
    $booking->addSlot(100_000);

    $booking->markPaid();

    $this->assertEquals('paid', $booking->status()->value);
  }

  public function test_cannot_pay_booking_twice(): void
  {
    $this->expectException(BookingException::class);

    $booking = new Booking(1, 1, 1);
    $booking->addSlot(100_000);
    $booking->markPaid();
    $booking->markPaid();
  }

  public function test_cannot_cancel_paid_booking(): void
  {
    $this->expectException(BookingException::class);

    $booking = new Booking(1, 1, 1);
    $booking->addSlot(100_000);
    $booking->markPaid();
    $booking->cancel();
  }
}
