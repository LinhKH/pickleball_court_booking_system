<?php

namespace App\Application\Payment;

final class PayBookingCommand
{
  public function __construct(
    public readonly int $bookingId
  ) {}
}
