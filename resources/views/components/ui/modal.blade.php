@props([
    'name',
    'title' => 'Modal Title',
    'subtitle' => null,
    'icon' => 'fa-solid fa-layer-group',
    'maxWidth' => '2xl' // sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl
])

@php
    $maxWidthClass = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        '5xl' => 'sm:max-w-5xl',
    ][$maxWidth] ?? 'sm:max-w-2xl';
@endphp

<div x-data="{ show: false }"
     x-show="show"
     x-on:open-modal.window="if ($event.detail === '{{ $name }}') show = true"
     x-on:close-modal.window="if ($event.detail === '{{ $name }}') show = false"
     x-on:keydown.escape.window="show = false"
     style="display: none;"
     class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0 flex items-center justify-center">

    <!-- Backdrop Overlay -->
    <div x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="show = false"
         class="fixed inset-0 bg-slate-950/80 backdrop-blur-md transition-opacity"></div>

    <!-- Modal Dialog Window -->
    <div x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="glass-card bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-2xl overflow-hidden w-full {{ $maxWidthClass }} my-8 transform transition-all relative z-10">

        <!-- Header -->
        <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-950/50">
            <div class="flex items-center space-x-3.5">
                <div class="w-10 h-10 rounded-2xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-blue-600 dark:text-amber-400">
                    <i class="{{ $icon }} text-lg"></i>
                </div>
                <div>
                    <h3 class="font-heading font-black text-lg text-slate-900 dark:text-white tracking-tight">{{ $title }}</h3>
                    @if($subtitle)
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
            <button @click="show = false" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-slate-900 dark:hover:text-white flex items-center justify-center transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Body Slot -->
        <div class="p-6 max-h-[75vh] overflow-y-auto">
            {{ $slot }}
        </div>
    </div>
</div>
