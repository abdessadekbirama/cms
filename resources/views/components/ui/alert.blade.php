{{-- resources/views/components/ui/alert.blade.php --}}
{{-- <x-ui.alert type="success|error">Message</x-ui.alert> --}}
@props(['type' => 'success'])

@php
    $isError = $type === 'error';
    $classes = $isError
        ? 'bg-red-50 border-red-100 text-red-700'
        : 'bg-emerald-50 border-emerald-100 text-emerald-700';
@endphp

<div {{ $attributes->merge(['class' => "flex items-start gap-2 rounded-xl border px-4 py-3 text-sm {$classes}"]) }} role="alert">
    @if ($isError)
        <x-lucide-circle-alert class="w-4 h-4 mt-0.5 shrink-0" />
    @else
        <x-lucide-circle-check class="w-4 h-4 mt-0.5 shrink-0" />
    @endif
    <div>{{ $slot }}</div>
</div>