<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyRatesService
{
    private const CACHE_KEY = 'currency.latest.v2';
    private const CACHE_TTL_SECONDS = 21600;

    public function latestRates(): array
    {
        $base = strtoupper(config('services.exchange_rates.base', 'EUR'));
        $symbols = config('services.exchange_rates.symbols', 'USD,GBP');
        $endpoint = config('services.exchange_rates.endpoint', 'https://api.exchangerate.host/latest');
        $key = config('services.exchange_rates.key');

        $cached = Cache::get(self::CACHE_KEY);
        if (!empty($cached['rates'])) {
            return $cached;
        }

        $params = [];
        if (str_contains($endpoint, '/live')) {
            $params['source'] = $base;
            $params['currencies'] = $symbols;
        } else {
            $params['base'] = $base;
            $params['symbols'] = $symbols;
        }

        if ($key) {
            $params['access_key'] = $key;
        }

        $response = Http::timeout(8)->get($endpoint, $params);

        if (!$response->ok()) {
            return [
                'base' => $base,
                'rates' => [],
            ];
        }

        $data = $response->json();

        if (isset($data['rates']) && is_array($data['rates'])) {
            $payload = [
                'base' => strtoupper($data['base'] ?? $base),
                'rates' => $data['rates'],
            ];

            if (!empty($payload['rates'])) {
                Cache::put(self::CACHE_KEY, $payload, self::CACHE_TTL_SECONDS);
            }

            return $payload;
        }

        if (isset($data['quotes']) && is_array($data['quotes'])) {
            $rates = [];
            $prefix = strtoupper($data['source'] ?? $base);

            foreach ($data['quotes'] as $pair => $rate) {
                if (!str_starts_with($pair, $prefix)) {
                    continue;
                }
                $currency = substr($pair, strlen($prefix));
                $rates[$currency] = $rate;
            }

            $payload = [
                'base' => $prefix,
                'rates' => $rates,
            ];

            if (!empty($payload['rates'])) {
                Cache::put(self::CACHE_KEY, $payload, self::CACHE_TTL_SECONDS);
            }

            return $payload;
        }

        return [
            'base' => $base,
            'rates' => [],
        ];
    }

    public function rateFor(string $currency): float
    {
        $currency = strtoupper($currency);
        $payload = $this->latestRates();
        $base = strtoupper($payload['base'] ?? 'EUR');

        if ($currency === $base) {
            return 1.0;
        }

        $rate = $payload['rates'][$currency] ?? null;
        if (!is_numeric($rate) || $rate <= 0) {
            return 1.0;
        }

        return (float) $rate;
    }
}
