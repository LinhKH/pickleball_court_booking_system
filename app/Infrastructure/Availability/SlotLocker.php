<?php

namespace App\Infrastructure\Availability;

use Illuminate\Support\Facades\Redis;

//📌 Redis chỉ nằm ở Infrastructure.
class SlotLocker
{
  private int $ttl = 300; // 5 phút

  public function lock(int $courtId, int $slotId, int $userId): bool
  {
    $key = $this->key($courtId, $slotId);

    return Redis::set(
      $key,
      (string) $userId,
      'NX',
      'EX',
      $this->ttl
    ) === true;
  }

  public function isLockedBy(int $courtId, int $slotId, int $userId): bool
  {
    $key = $this->key($courtId, $slotId);

    return Redis::get($key) == (string) $userId;
  }

  public function release(int $courtId, int $slotId): void
  {
    Redis::del($this->key($courtId, $slotId));
  }

  private function key(int $courtId, int $slotId): string
  {
    return "slot_lock:{$courtId}:{$slotId}";
  }

  public function isLocked(int $courtId, int $slotId): bool
  {
    return Redis::exists($this->key($courtId, $slotId)) === 1;
  }
}
