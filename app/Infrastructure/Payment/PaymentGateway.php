<?php

namespace App\Infrastructure\Payment;

interface PaymentGateway
{
  public function pay(int $bookingId, int $amount): bool;
}
