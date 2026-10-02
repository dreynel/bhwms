@props([
    'title',
    'value',
    'icon',
    'color' => 'blue', // blue, emerald, amber, rose, indigo, teal
    'trend' => null,
    'trendUp' => true
])

@php
    $colorMap = [
        'blue' => [
            'bg' => 'bg-blue-500/10 dark:bg-blue-500/20',
            'border' => 'border-blue-500/30',
            'text' => 'text-blue-600 dark:text-blue-400',
            'glow' => 'from-blue-600/10 via-indigo-600/5 to-transparent'
        ],
        'emerald' => [
            'bg' => 'bg-emerald-500/10 dark:bg-emerald-500/20',
            'border' => 'border-emerald-500/30',
            'text' => 'text-emerald-600 dark:text-emerald-400',
            'glow' => 'from-emerald-600/10 via-teal-600/5 to-transparent'
        ],
        'amber' => [
            'bg' => 'bg-amber-500/10 dark:bg-amber-500/20',
            'border' => 'border-amber-500/30',
            'text' => 'text-amber-600 dark:text-amber-400',
            'glow' => 'from-amber-600/10 via-yellow-600/5 to-transparent'
        ],
        'rose' => [
            'bg' => 'bg-rose-500/10 dark:bg-rose-500/20',
            'border' => 'border-rose-500/30',
            'text' => 'text-rose-600 dark:text-rose-400',
            'glow' => 'from-rose-600/10 via-pink-600/5 to-transparent'
        ],
        'indigo' => [
            'bg' => 'bg-indigo-500/10 dark:bg-indigo-500/20',
            'border' => 'border-indigo-500/30',
            'text' => 'text-indigo-600 dark:text-indigo-400',
            'glow' => 'from-indigo-600/10 via-purple-600/5 to-transparent'
        ],
        'teal' => [
            'bg' => 'bg-teal-500/10 dark:bg-teal-500/20',
            'border' => 'border-teal-500/30',
            'text' => 'text-teal-600 dark:text-teal-400',
            'glow' => 'from-teal-600/10 via-emerald-600/5 to-transparent'
        ],
    ];
    $c = $colorMap[$color] ?? $colorMap['blue'];
@endphp

<div {{ $attributes->merge(['class' => 'glass-card glass-card-hover rounded-3xl p-6 relative overflow-hidden transition duration-300']) }}>
    <!-- Ambient Gradient Background Glow -->
    <div class="absolute -top-12 -right-12 w-32 h-32 bg-gradient-to-br {{ $c['glow'] }} rounded-full blur-2xl pointer-events-none"></div>

    <div class="flex items-center justify-between relative z-10">
        <div>
            <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ $title }}</p>
            <h3 class="font-heading font-black text-3xl text-slate-900 dark:text-white mt-1 tracking-tight">{{ $value }}</h3>
            @if($trend)
                <p class="text-[11px] font-semibold mt-2 flex items-center {{ $trendUp ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                    <i class="fa-solid {{ $trendUp ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} mr-1"></i>
                    <span>{{ $trend }}</span>
                </p>
            @endif
        </div>
        <div class="w-12 h-12 rounded-2xl {{ $c['bg'] }} border {{ $c['border'] }} flex items-center justify-center {{ $c['text'] }} shadow-md">
            <i class="{{ $icon }} text-xl"></i>
        </div>
    </div>
</div>
