<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function set(Request $request): RedirectResponse
    {
        $base = strtoupper(config('services.exchange_rates.base', 'EUR'));
        $symbols = array_filter(array_map('trim', explode(',', config('services.exchange_rates.symbols', 'USD,GBP'))));
        $supported = array_unique(array_merge([$base], array_map('strtoupper', $symbols)));

        $currency = strtoupper((string) $request->input('currency', $base));

        if (!in_array($currency, $supported, true)) {
            $currency = $base;
        }

        $request->session()->put('currency', $currency);

        return back();
    }
}
