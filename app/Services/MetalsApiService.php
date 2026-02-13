<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MetalsApiService
{
    private const CACHE_KEY = 'metals.latest';
    private const CACHE_TTL_SECONDS = 3600;

    public function latest(): ?array
    {
        $key = config('services.metals.key');
        if (!$key) {
            return null;
        }

        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL_SECONDS, function () use ($key) {
            $currency = config('services.metals.currency', 'EUR');
            $unit = config('services.metals.unit', 'toz');

            $response = Http::timeout(8)->get('https://api.metals.dev/v1/latest', [
                'api_key' => $key,
                'currency' => $currency,
                'unit' => $unit,
            ]);

            if (!$response->ok()) {
                return null;
            }

            $data = $response->json();

            if (($data['status'] ?? '') !== 'success') {
                return null;
            }

            if (!isset($data['metals']) || !is_array($data['metals'])) {
                return null;
            }

            return [
                'currency' => $data['currency'] ?? $currency,
                'unit' => $data['unit'] ?? $unit,
                'timestamp' => $data['timestamp'] ?? null,
                'metals' => $data['metals'],
            ];
        });
    }

    public function latestPrices(): ?array
    {
        $payload = $this->latest();
        if (!$payload) {
            return null;
        }

        $metalCodes = array_filter(array_map('trim', explode(',', config('services.metals.metals', 'gold,silver,platinum'))));
        $prices = [];

        foreach ($metalCodes as $code) {
            $price = $payload['metals'][$code] ?? null;
            if (!$price || !is_numeric($price) || $price <= 0) {
                continue;
            }
            $prices[$code] = $price;
        }

        if (!$prices) {
            return null;
        }

        return [
            'currency' => $payload['currency'],
            'unit' => $payload['unit'],
            'timestamp' => $payload['timestamp'],
            'prices' => $prices,
        ];
    }
}
