@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'action' => null
])

<div {{ $attributes->merge(['class' => 'glass-card glass-card-hover rounded-3xl p-6 transition duration-300']) }}>
    @if($title || $icon || $action)
        <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800/80 pb-4 mb-5">
            <div class="flex items-center space-x-3">
                @if($icon)
                    <div class="w-10 h-10 rounded-2xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <i class="{{ $icon }} text-lg"></i>
                    </div>
                @endif
                <div>
                    @if($title)
                        <h3 class="font-heading font-extrabold text-lg text-slate-900 dark:text-white tracking-tight">{{ $title }}</h3>
                    @endif
                    @if($subtitle)
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
            @if($action)
                <div>
                    {{ $action }}
                </div>
            @endif
        </div>
    @endif

    <div>
        {{ $slot }}
    </div>
</div>
