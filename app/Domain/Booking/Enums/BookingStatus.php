<?php
enum BookingStatus: string
{
  case Pending   = 'pending';
  case Paid      = 'paid';
  case Cancelled = 'cancelled';
  case Expired   = 'expired';
  case Completed = 'completed';
}
