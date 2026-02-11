<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Payment\PaymentGateway;
use App\Infrastructure\Payment\MockPaymentGateway;

class PaymentServiceProvider extends ServiceProvider
{
  public function register(): void
  {
    $this->app->bind(
      PaymentGateway::class,
      MockPaymentGateway::class
    );
  }
}
