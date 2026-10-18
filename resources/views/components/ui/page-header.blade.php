{{-- resources/views/components/ui/page-header.blade.php --}}
{{--
    <x-ui.page-header title="Posts" description="Manage your articles.">
        <x-slot:actions> ...buttons... </x-slot:actions>
    </x-ui.page-header>
--}}
@props(['title', 'description' => null])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">{{ $title }}</h1>
        @if ($description)
            <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex items-center gap-2">{{ $actions }}</div>
    @endisset
</div>