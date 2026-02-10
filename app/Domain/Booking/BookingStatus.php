<?php

namespace App\Domain\Booking;

enum BookingStatus: string
{
  case Pending   = 'pending'; //vừa tạo, chưa thanh toán
  case Paid      = 'paid'; // đã thanh toán
  case Cancelled = 'cancelled'; // huỷ
  case Expired   = 'expired'; // quá hạn thanh toán
  case Completed = 'completed';
}
