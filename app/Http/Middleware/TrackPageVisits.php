<?php

namespace App\Http\Middleware;

use App\Services\SiteMetricsService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackPageVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!$request->isMethod('get')) {
            return $response;
        }

        if ($request->ajax() || $request->expectsJson()) {
            return $response;
        }

        $path = $request->path();
        $normalized = $path === '/' || $path === '' ? '/' : '/' . ltrim($path, '/');

        $skipPrefixes = [
            '/admin',
            '/api',
            '/storage',
            '/build',
            '/vendor',
            '/_ignition',
            '/telescope',
        ];

        if (Str::startsWith($normalized, $skipPrefixes)) {
            return $response;
        }

        if (!Schema::hasTable('page_visits')) {
            return $response;
        }

        $now = now();
        $row = DB::table('page_visits')->where('path', $normalized);

        if ($row->exists()) {
            $row->increment('count');
            $row->update(['last_visited_at' => $now, 'updated_at' => $now]);
        } else {
            DB::table('page_visits')->insert([
                'path' => $normalized,
                'count' => 1,
                'last_visited_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (Schema::hasTable('site_metrics')) {
            app(SiteMetricsService::class)->increment('page_visits_total');
        }

        return $response;
    }
}
