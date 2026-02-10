<?php

namespace App\Infrastructure\Availability;

use Illuminate\Support\Facades\Redis;

//📌 Redis chỉ nằm ở Infrastructure.
class SlotLocker
{
  private int $ttl = 300; // 5 phút

  // public function lock(int $courtId, int $slotId, int $userId): bool
  // {
  //   $key = $this->key($courtId, $slotId);

  //   return Redis::set(
  //     $key,
  //     (string) $userId,
  //     'NX',
  //     'EX',
  //     $this->ttl
  //   ) === true;
  // }

  // public function isLockedBy(int $courtId, int $slotId, int $userId): bool
  // {
  //   $key = $this->key($courtId, $slotId);

  //   return Redis::get($key) == (string) $userId;
  // }

  // public function release(int $courtId, int $slotId): void
  // {
  //   Redis::del($this->key($courtId, $slotId));
  // }

  // private function key(int $courtId, int $slotId): string
  // {
  //   return "slot_lock:{$courtId}:{$slotId}";
  // }

  // public function isLocked(int $courtId, int $slotId): bool
  // {
  //   return Redis::exists($this->key($courtId, $slotId)) === 1;
  // }

  public function lock(
    int $courtUnitId,
    string $date,
    string $startTime,
    int $userId
  ): bool {
    return Redis::set(
      $this->key($courtUnitId, $date, $startTime),
      (string) $userId,
      'NX',
      'EX',
      $this->ttl
    ) === true;
  }

  public function isLocked(
    int $courtUnitId,
    string $date,
    string $startTime
  ): bool {
    return Redis::exists(
      $this->key($courtUnitId, $date, $startTime)
    ) === 1;
  }

  public function isLockedBy(
    int $courtUnitId,
    string $date,
    string $startTime,
    int $userId
  ): bool {
    return Redis::get(
      $this->key($courtUnitId, $date, $startTime)
    ) == (string) $userId;
  }

  public function release(
    int $courtUnitId,
    string $date,
    string $startTime
  ): void {
    Redis::del(
      $this->key($courtUnitId, $date, $startTime)
    );
  }

  private function key(
    int $courtUnitId,
    string $date,
    string $startTime
  ): string {
    return "slot_lock:{$courtUnitId}:{$date}:{$startTime}";
  }
}
