@extends('layouts.admin')

@section('content')
<div>
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gold mb-2">Estadisticas</h1>
        <p class="text-silver/70">Resumen de visitas, compras y rendimiento.</p>
    </div>

    <div x-data="dashboardApi()" x-init="load()">
        <div class="flex flex-col items-start gap-2 mb-6">
            <h2 class="text-2xl font-bold text-gold">Resumen en vivo</h2>
            <p class="text-silver/80" x-text="status"></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="rounded-xl border border-gold/20 bg-graphite p-6">
                <p class="text-sm text-silver/60">Visitas totales</p>
                <p class="mt-2 text-3xl font-bold text-gold" x-text="summary.page_visits_total"></p>
            </div>
            <div class="rounded-xl border border-gold/20 bg-graphite p-6">
                <p class="text-sm text-silver/60">Compras simuladas</p>
                <p class="mt-2 text-3xl font-bold text-gold" x-text="summary.checkout_clicks"></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="rounded-xl border border-gold/20 bg-graphite p-6">
                <h3 class="text-lg font-semibold text-gold mb-4">Top Favoritos</h3>
                <template x-if="topFavorites.length === 0">
                    <p class="text-silver/70 text-sm">Sin datos disponibles.</p>
                </template>
                <ul class="space-y-2" x-show="topFavorites.length > 0">
                    <template x-for="item in topFavorites" :key="item.id">
                        <li class="flex items-center justify-between text-sm text-silver">
                            <span x-text="item.name"></span>
                            <span class="text-gold" x-text="item.favorites"></span>
                        </li>
                    </template>
                </ul>
            </div>

            <div class="rounded-xl border border-gold/20 bg-graphite p-6">
                <h3 class="text-lg font-semibold text-gold mb-4">Mas vistos</h3>
                <template x-if="topViewed.length === 0">
                    <p class="text-silver/70 text-sm">Sin datos disponibles.</p>
                </template>
                <ul class="space-y-2" x-show="topViewed.length > 0">
                    <template x-for="item in topViewed" :key="item.id">
                        <li class="flex items-center justify-between text-sm text-silver">
                            <span x-text="item.name"></span>
                            <span class="text-gold" x-text="item.views"></span>
                        </li>
                    </template>
                </ul>
            </div>

            <div class="rounded-xl border border-gold/20 bg-graphite p-6">
                <h3 class="text-lg font-semibold text-gold mb-4">Paginas mas visitadas</h3>
                <template x-if="topPages.length === 0">
                    <p class="text-silver/70 text-sm">Sin datos disponibles.</p>
                </template>
                <ul class="space-y-2" x-show="topPages.length > 0">
                    <template x-for="item in topPages" :key="item.path">
                        <li class="flex items-center justify-between text-sm text-silver">
                            <span x-text="item.path"></span>
                            <span class="text-gold" x-text="item.count"></span>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
