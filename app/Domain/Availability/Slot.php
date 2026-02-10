<?php

namespace App\Domain\Availability;
//Domain Entity
final class Slot
{
  public function __construct(
    private int $id,
    private SlotStatus $status
  ) {}

  public function id(): int
  {
    return $this->id;
  }

  public function status(): SlotStatus
  {
    return $this->status;
  }
}
