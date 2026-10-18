{{-- resources/views/posts/show.blade.php --}}
<x-layouts.app :title="$post->title">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">

        <x-ui.button :href="route('posts.index')" variant="ghost" size="sm" icon="arrow-left" class="mb-4 -ml-3">
            Back to posts
        </x-ui.button>

        @if (session('status'))
            <x-ui.alert class="mb-6">{{ session('status') }}</x-ui.alert>
        @endif

        <x-ui.card class="p-6 sm:p-10">
            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                <x-ui.badge :status="$post->status" />

                <span class="inline-flex items-center gap-1.5">
                    <x-lucide-user class="w-4 h-4" /> {{ $post->user->name }}
                </span>

                <span class="inline-flex items-center gap-1.5">
                    <x-lucide-calendar class="w-4 h-4" />
                    {{ ($post->published_at ?? $post->created_at)->format('M d, Y') }}
                </span>
            </div>

            <h1 class="mt-4 text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">{{ $post->title }}</h1>

            @if ($post->excerpt)
                <p class="mt-4 text-lg text-gray-500">{{ $post->excerpt }}</p>
            @endif

            <hr class="my-8 border-gray-100">

            <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $post->body }}</div>

            <hr class="my-8 border-gray-100">

            <div class="flex items-center justify-between gap-3">
                <x-ui.button :href="route('posts.edit', $post)" variant="secondary" icon="pencil">Edit</x-ui.button>

                <x-ui.delete-button :action="route('posts.destroy', $post)"
                    confirm="Delete this post? This cannot be undone.">
                    Delete post
                </x-ui.delete-button>
            </div>
        </x-ui.card>
    </div>
</x-layouts.app>