<?php

namespace App\Infrastructure\Payment;

class MockPaymentGateway implements PaymentGateway
{
  public function pay(int $bookingId, int $amount): bool
  {
    // Giả lập thanh toán thành công
    return true;
  }
}
//👉 Sau này thay bằng VNPay / Stripe / GMO không ảnh hưởng core.