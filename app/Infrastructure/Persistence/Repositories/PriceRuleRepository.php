<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Models\CourtPriceRule;
use Illuminate\Support\Collection;

/**
 * 📌 Chỉ làm 1 việc:
Lấy data từ DB
 */


class PriceRuleRepository
{
    /**
     * @return Collection|CourtPriceRule[]
     */
    public function getByCourt(int $courtId): Collection
    {
        return CourtPriceRule::query()
            ->where('court_id', $courtId)
            ->where('is_active', true)
            ->orderByDesc('priority')
            ->get(); // ❗ KHÔNG toArray()
    }
}