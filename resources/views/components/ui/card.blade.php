{{-- resources/views/components/ui/card.blade.php --}}
<div {{ $attributes->merge(['class' => 'bg-white border border-gray-100 rounded-2xl shadow-sm']) }}>
    {{ $slot }}
</div>