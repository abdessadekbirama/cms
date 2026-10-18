{{-- resources/views/components/ui/input.blade.php --}}
{{-- <x-ui.input name="title" label="Title" icon="type" :value="$post->title" hint="..." /> --}}
@props([
    'name',
    'label' => null,
    'type' => 'text',
    'icon' => null,
    'hint' => null,
    'value' => null,
])

@php
    $id = $attributes->get('id', $name);
    $hasError = $errors->has($name);

    $inputClass = 'w-full ' . ($icon ? 'pl-12' : 'pl-4') . ' pr-4 py-3 rounded-xl border bg-gray-50 text-gray-900 placeholder-gray-400 outline-none transition focus:bg-white focus:ring-4 '
        . ($hasError
            ? 'border-red-300 focus:border-red-500 focus:ring-red-100'
            : 'border-gray-200 focus:border-indigo-500 focus:ring-indigo-100');
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" class="block mb-2 text-sm font-semibold text-gray-700">{{ $label }}</label>
    @endif

    <div class="relative group">
        @if ($icon)
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 transition-colors {{ $hasError ? 'text-red-400' : 'text-gray-400 group-focus-within:text-indigo-600' }}">
                <x-dynamic-component :component="'lucide-' . $icon" class="w-5 h-5" />
            </span>
        @endif

        <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}"
            {{ $attributes->merge(['id' => $id, 'class' => $inputClass]) }}>
    </div>

    @if ($hint && ! $hasError)
        <p class="mt-1.5 text-xs text-gray-400">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 flex items-center gap-1 text-sm text-red-600">
            <x-lucide-circle-alert class="w-4 h-4 shrink-0" />
            {{ $message }}
        </p>
    @enderror
</div>