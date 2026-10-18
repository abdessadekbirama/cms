{{-- resources/views/components/ui/select.blade.php --}}
{{-- <x-ui.select name="status" :options="['draft' => 'Draft', 'published' => 'Published']" :value="request('status')" /> --}}
@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
])

@php
    $id = $attributes->get('id', $name);
    $hasError = $errors->has($name);
    $current = (string) old($name, $value);

    $class = 'w-full pl-4 pr-10 py-3 rounded-xl border bg-gray-50 text-gray-900 outline-none transition appearance-none focus:bg-white focus:ring-4 '
        . ($hasError
            ? 'border-red-300 focus:border-red-500 focus:ring-red-100'
            : 'border-gray-200 focus:border-indigo-500 focus:ring-indigo-100');
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" class="block mb-2 text-sm font-semibold text-gray-700">{{ $label }}</label>
    @endif

    <div class="relative">
        <select name="{{ $name }}" {{ $attributes->merge(['id' => $id, 'class' => $class]) }}>
            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected($current === (string) $optionValue)>{{ $optionLabel }}</option>
            @endforeach
        </select>
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400">
            <x-lucide-chevron-down class="w-4 h-4" />
        </span>
    </div>

    @error($name)
        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>