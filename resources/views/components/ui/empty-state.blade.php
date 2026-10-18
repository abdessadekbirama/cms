{{-- resources/views/components/ui/empty-state.blade.php --}}
{{-- <x-ui.empty-state icon="file-text" title="No posts" description="..."> <x-ui.button .../> </x-ui.empty-state> --}}
@props(['icon' => 'inbox', 'title', 'description' => null])

<div class="px-6 py-16 text-center">
    <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
        <x-dynamic-component :component="'lucide-' . $icon" class="w-7 h-7" />
    </div>

    <p class="mt-4 font-semibold text-gray-800">{{ $title }}</p>

    @if ($description)
        <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
    @endif

    @if ($slot->isNotEmpty())
        <div class="mt-6">{{ $slot }}</div>
    @endif
</div>