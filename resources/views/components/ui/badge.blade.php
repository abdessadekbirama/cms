{{-- resources/views/components/ui/badge.blade.php --}}
{{-- <x-ui.badge :status="$post->status" /> --}}
@props(['status' => 'draft'])

@php
    $styles = [
        'published' => ['bg-emerald-50 text-emerald-700', 'bg-emerald-500', 'Published'],
        'draft' => ['bg-amber-50 text-amber-700', 'bg-amber-500', 'Draft'],
    ];

    [$wrap, $dot, $text] = $styles[$status] ?? ['bg-gray-100 text-gray-600', 'bg-gray-400', ucfirst($status)];
@endphp

<span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium {{ $wrap }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
    {{ $text }}
</span>