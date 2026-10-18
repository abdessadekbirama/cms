{{-- resources/views/components/ui/textarea.blade.php --}}
{{-- <x-ui.textarea name="body" label="Content" rows="12" :value="$post->body" /> --}}
@props([
    'name',
    'label' => null,
    'hint' => null,
    'value' => null,
])

@php
    $id = $attributes->get('id', $name);
    $hasError = $errors->has($name);

    $class = 'w-full px-4 py-3 rounded-xl border bg-gray-50 text-gray-900 placeholder-gray-400 outline-none transition focus:bg-white focus:ring-4 '
        . ($hasError
            ? 'border-red-300 focus:border-red-500 focus:ring-red-100'
            : 'border-gray-200 focus:border-indigo-500 focus:ring-indigo-100');
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" class="block mb-2 text-sm font-semibold text-gray-700">{{ $label }}</label>
    @endif

    <textarea name="{{ $name }}" {{ $attributes->merge(['id' => $id, 'rows' => 4, 'class' => $class]) }}>{{ old($name, $value) }}</textarea>

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