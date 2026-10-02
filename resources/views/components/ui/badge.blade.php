@props([
    'type' => 'info', // success, warning, error, info, neutral
    'size' => 'md', // sm, md
    'icon' => null
])

@php
    $typeMap = [
        'success' => 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border-emerald-500/30',
        'warning' => 'bg-amber-500/10 text-amber-700 dark:text-amber-300 border-amber-500/30',
        'error' => 'bg-rose-500/10 text-rose-700 dark:text-rose-300 border-rose-500/30',
        'info' => 'bg-blue-500/10 text-blue-700 dark:text-blue-300 border-blue-500/30',
        'neutral' => 'bg-slate-500/10 text-slate-700 dark:text-slate-300 border-slate-500/30',
    ];
    $sizeMap = [
        'sm' => 'px-2 py-0.5 text-[10px]',
        'md' => 'px-2.5 py-1 text-xs',
    ];
    $style = $typeMap[$type] ?? $typeMap['info'];
    $sz = $sizeMap[$size] ?? $sizeMap['md'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center space-x-1 font-bold rounded-lg border {$style} {$sz} tracking-wide uppercase"]) }}>
    @if($icon)
        <i class="{{ $icon }} text-[10px]"></i>
    @endif
    <span>{{ $slot }}</span>
</span>
