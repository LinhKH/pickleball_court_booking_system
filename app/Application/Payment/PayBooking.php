<?php

namespace App\Application\Payment;

use App\Infrastructure\Availability\SlotLocker;
use App\Infrastructure\Payment\PaymentGateway;
use App\Infrastructure\Persistence\Repositories\BookingRepository;

final class PayBooking
{
  public function __construct(
    private BookingRepository $bookingRepo,
    private SlotLocker $locker,
    private PaymentGateway $gateway
  ) {}

  public function execute(PayBookingCommand $command): void
  {
    $booking = $this->bookingRepo->findDomain($command->bookingId);

    // 1️⃣ payment
    $paid = $this->gateway->pay(
      $command->bookingId,
      $booking->totalPrice()
    );

    if (! $paid) {
      throw new \DomainException('Payment failed');
    }

    // 2️⃣ mark paid
    $booking->markPaid();
    $this->bookingRepo->updateStatus($booking);

    // 3️⃣ release redis locks
    foreach ($this->bookingRepo->getSlots($command->bookingId) as $slot) {
      $this->locker->release(
        $slot->court_unit_id,
        $slot->date,
        $slot->start_time
      );
    }
  }
}
