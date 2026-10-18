{{-- resources/views/posts/index.blade.php --}}
<x-layouts.app title="Posts">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">

        <x-ui.page-header title="Posts" description="Manage your articles and drafts.">
            <x-slot:actions>
                <x-ui.button :href="route('posts.create')" icon="plus">New post</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        @if (session('status'))
            <x-ui.alert class="mb-6">{{ session('status') }}</x-ui.alert>
        @endif

        {{-- Filters --}}
        <form method="GET" action="{{ route('posts.index') }}" class="flex flex-col sm:flex-row gap-3 mb-6">
            <div class="flex-1">
                <x-ui.input name="q" type="search" icon="search" placeholder="Search posts..." :value="request('q')" />
            </div>

            <div class="sm:w-48">
                <x-ui.select name="status"
                    :options="['' => 'All statuses', 'published' => 'Published', 'draft' => 'Draft']"
                    :value="request('status')" />
            </div>

            <x-ui.button type="submit" variant="secondary" icon="list-filter">Filter</x-ui.button>

            @if (request()->hasAny(['q', 'status']))
                <x-ui.button :href="route('posts.index')" variant="ghost" icon="x">Reset</x-ui.button>
            @endif
        </form>

        {{-- Table --}}
        <x-ui.card class="overflow-hidden">
            @if ($posts->count())
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-6 py-3">Title</th>
                            <th class="px-6 py-3 hidden sm:table-cell">Status</th>
                            <th class="px-6 py-3 hidden md:table-cell">Updated</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach ($posts as $post)
                            <tr class="hover:bg-gray-50/60 transition-colors">
                                <td class="px-6 py-4">
                                    <a href="{{ route('posts.show', $post) }}" class="font-semibold text-gray-900 hover:text-indigo-600 transition-colors">
                                        {{ $post->title }}
                                    </a>
                                    <p class="text-xs text-gray-400">/{{ $post->slug }}</p>
                                </td>

                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <x-ui.badge :status="$post->status" />
                                </td>

                                <td class="px-6 py-4 hidden md:table-cell text-gray-500">
                                    {{ $post->updated_at->diffForHumans() }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <x-ui.icon-button icon="eye" title="View" :href="route('posts.show', $post)" />
                                        <x-ui.icon-button icon="pencil" title="Edit" tone="primary" :href="route('posts.edit', $post)" />
                                        <x-ui.delete-button :action="route('posts.destroy', $post)" icon-only
                                            confirm="Delete this post? This cannot be undone." />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <x-ui.empty-state icon="file-text" title="No posts found"
                    description="Try a different search, or create your first post.">
                    <x-ui.button :href="route('posts.create')" icon="plus">New post</x-ui.button>
                </x-ui.empty-state>
            @endif
        </x-ui.card>

        <div class="mt-6">{{ $posts->links() }}</div>
    </div>
</x-layouts.app>