<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SiteMetricsService
{
    public function increment(string $key, int $by = 1): void
    {
        $updated = DB::table('site_metrics')
            ->where('key', $key)
            ->increment('count', $by);

        if ($updated === 0) {
            DB::table('site_metrics')->insert([
                'key' => $key,
                'count' => $by,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('site_metrics')
                ->where('key', $key)
                ->update(['updated_at' => now()]);
        }
    }

    public function get(string $key): int
    {
        $value = DB::table('site_metrics')
            ->where('key', $key)
            ->value('count');

        return (int) ($value ?? 0);
    }
}
