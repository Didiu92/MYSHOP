<?php

namespace App\Providers;

use App\Services\CurrencyRatesService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $base = strtoupper(config('services.exchange_rates.base', 'EUR'));
            $symbols = array_filter(array_map('trim', explode(',', config('services.exchange_rates.symbols', 'USD,GBP'))));
            $supported = array_unique(array_merge([$base], array_map('strtoupper', $symbols)));

            $currency = strtoupper(session('currency', $base));
            if (!in_array($currency, $supported, true)) {
                $currency = $base;
            }

            $symbolsMap = [
                'EUR' => '€',
                'USD' => '$',
                'GBP' => '£',
            ];

            $currencySymbol = $symbolsMap[$currency] ?? ($currency . ' ');
            $rate = app(CurrencyRatesService::class)->rateFor($currency);

            $currencyOptions = [];
            foreach ($supported as $code) {
                $labelSymbol = $symbolsMap[$code] ?? $code;
                $currencyOptions[$code] = $code . ' (' . $labelSymbol . ')';
            }

            $view->with('currency', $currency)
                ->with('currencyRate', $rate)
                ->with('currencySymbol', $currencySymbol)
                ->with('currencyOptions', $currencyOptions);
        });
    }
}
