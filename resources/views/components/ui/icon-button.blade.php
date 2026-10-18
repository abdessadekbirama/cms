{{-- resources/views/components/ui/icon-button.blade.php --}}
{{-- <x-ui.icon-button icon="pencil" title="Edit" :href="route('posts.edit', $post)" /> --}}
@props([
    'icon',
    'title' => null,
    'href' => null,
    'tone' => 'default', // default | primary | danger
])

@php
    $tones = [
        'default' => 'text-gray-500 hover:bg-gray-100 hover:text-gray-900',
        'primary' => 'text-gray-500 hover:bg-indigo-50 hover:text-indigo-600',
        'danger' => 'text-gray-500 hover:bg-red-50 hover:text-red-600',
    ];

    $classes = 'inline-flex p-2 rounded-lg transition ' . ($tones[$tone] ?? $tones['default']);
@endphp

@if ($href)
    <a href="{{ $href }}" title="{{ $title }}" aria-label="{{ $title }}" {{ $attributes->merge(['class' => $classes]) }}>
        <x-dynamic-component :component="'lucide-' . $icon" class="w-4 h-4" />
    </a>
@else
    <button type="submit" title="{{ $title }}" aria-label="{{ $title }}" {{ $attributes->merge(['class' => $classes]) }}>
        <x-dynamic-component :component="'lucide-' . $icon" class="w-4 h-4" />
    </button>
@endif