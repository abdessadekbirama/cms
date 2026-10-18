{{-- resources/views/livewire/posts/index.blade.php --}}
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Posts</h1>
            <p class="mt-1 text-sm text-gray-500">Manage your articles and drafts.</p>
        </div>

        <a href="{{ route('posts.create') }}" wire:navigate
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-lg shadow-indigo-600/25 transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
            <x-lucide-plus class="w-4 h-4" />
            New post
        </a>
    </div>

    {{-- Flash message --}}
    @if (session('status'))
        <div class="mb-6 flex items-center gap-2 rounded-xl bg-emerald-50 border border-emerald-100 px-4 py-3 text-sm text-emerald-700">
            <x-lucide-circle-check class="w-4 h-4 shrink-0" />
            {{ session('status') }}
        </div>
    @endif

    {{-- Filters --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <div class="relative flex-1">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <x-lucide-search class="w-4 h-4" />
            </span>
            <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search posts..."
                class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
        </div>

        <select wire:model.live="status"
            class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            <option value="">All statuses</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden bg-white border border-gray-100 rounded-2xl shadow-sm">
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
                @forelse ($posts as $post)
                    <tr wire:key="post-{{ $post->id }}" class="hover:bg-gray-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $post->title }}</p>
                            <p class="text-xs text-gray-400">/{{ $post->slug }}</p>
                        </td>

                        <td class="px-6 py-4 hidden sm:table-cell">
                            @if ($post->isPublished())
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Draft
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 hidden md:table-cell text-gray-500">
                            {{ $post->updated_at->diffForHumans() }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1">
                                <button wire:click="togglePublish({{ $post->id }})"
                                    title="{{ $post->isPublished() ? 'Unpublish' : 'Publish' }}"
                                    class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 transition">
                                    @if ($post->isPublished())
                                        <x-lucide-eye-off class="w-4 h-4" />
                                    @else
                                        <x-lucide-send class="w-4 h-4" />
                                    @endif
                                </button>

                                <a href="{{ route('posts.edit', $post) }}" wire:navigate title="Edit"
                                    class="p-2 rounded-lg text-gray-500 hover:bg-indigo-50 hover:text-indigo-600 transition">
                                    <x-lucide-pencil class="w-4 h-4" />
                                </a>

                                <button wire:click="delete({{ $post->id }})"
                                    wire:confirm="Delete this post? This cannot be undone." title="Delete"
                                    class="p-2 rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600 transition">
                                    <x-lucide-trash-2 class="w-4 h-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <x-lucide-file-text class="w-10 h-10 mx-auto text-gray-300" />
                            <p class="mt-3 font-semibold text-gray-700">No posts found</p>
                            <p class="text-sm text-gray-400">Create your first post to get started.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $posts->links() }}</div>
</div>