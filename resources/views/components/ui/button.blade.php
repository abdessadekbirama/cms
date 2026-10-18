{{-- resources/views/components/ui/button.blade.php --}}
{{-- <x-ui.button variant="primary|secondary|danger|ghost" size="sm|md|lg" icon="plus" href="..."> --}}
@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'icon' => null,
    'type' => 'button',
])

@php
    $variants = [
        'primary' => 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25 hover:bg-indigo-700 focus:ring-indigo-200',
        'secondary' => 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50 focus:ring-gray-100',
        'danger' => 'bg-red-600 text-white shadow-lg shadow-red-600/25 hover:bg-red-700 focus:ring-red-200',
        'ghost' => 'text-gray-600 hover:bg-gray-100 focus:ring-gray-100',
    ];

    $sizes = [
        'sm' => 'px-3 py-2 text-xs',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-5 py-3.5 text-sm',
    ];

    $classes = 'inline-flex items-center justify-center gap-2 font-semibold rounded-xl transition focus:outline-none focus:ring-4 disabled:opacity-60 active:scale-[0.98] '
        . ($variants[$variant] ?? $variants['primary']) . ' '
        . ($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon) <x-dynamic-component :component="'lucide-' . $icon" class="w-4 h-4" /> @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon) <x-dynamic-component :component="'lucide-' . $icon" class="w-4 h-4" /> @endif
        {{ $slot }}
    </button>
@endif