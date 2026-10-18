{{-- resources/views/components/ui/delete-button.blade.php --}}
{{--
    Icon only (tables):  <x-ui.delete-button :action="route('posts.destroy', $post)" icon-only />
    Full button:         <x-ui.delete-button :action="route('posts.destroy', $post)">Delete post</x-ui.delete-button>
--}}
@props([
    'action',
    'confirm' => 'Delete this item? This cannot be undone.',
    'iconOnly' => false,
])

<form method="POST" action="{{ $action }}" onsubmit="return confirm(@js($confirm))" class="inline">
    @csrf
    @method('DELETE')

    @if ($iconOnly)
        <x-ui.icon-button icon="trash-2" title="Delete" tone="danger" />
    @else
        <x-ui.button type="submit" variant="danger" icon="trash-2">
            {{ $slot->isEmpty() ? 'Delete' : $slot }}
        </x-ui.button>
    @endif
</form>