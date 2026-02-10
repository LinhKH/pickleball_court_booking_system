<?php

namespace App\Domain\Availability;

// ENUM
enum SlotStatus: string
{
  case Available = 'available';
  case Booked    = 'booked';
}
