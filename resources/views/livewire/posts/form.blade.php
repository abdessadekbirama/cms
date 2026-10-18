{{-- resources/views/livewire/posts/form.blade.php --}}
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">

    <a href="{{ route('posts.index') }}" wire:navigate
        class="inline-flex items-center gap-1.5 mb-6 text-sm font-medium text-gray-500 hover:text-gray-900 transition">
        <x-lucide-arrow-left class="w-4 h-4" />
        Back to posts
    </a>

    <form wire:submit="save" class="p-8 bg-white border border-gray-100 rounded-2xl shadow-sm space-y-6">

        <h1 class="text-2xl font-bold tracking-tight text-gray-900">
            {{ $post?->exists ? 'Edit post' : 'New post' }}
        </h1>

        {{-- Title --}}
        <div>
            <label for="title" class="block mb-2 text-sm font-semibold text-gray-700">Title</label>
            <input id="title" type="text" wire:model.live.debounce.400ms="title" placeholder="Post title"
                class="w-full px-4 py-3 rounded-xl border bg-gray-50 outline-none transition focus:bg-white focus:ring-4
                {{ $errors->has('title') ? 'border-red-300 focus:border-red-500 focus:ring-red-100' : 'border-gray-200 focus:border-indigo-500 focus:ring-indigo-100' }}">
            @error('title') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Slug --}}
        <div>
            <label for="slug" class="block mb-2 text-sm font-semibold text-gray-700">Slug</label>
            <div class="flex rounded-xl border bg-gray-50 transition focus-within:bg-white focus-within:ring-4
                {{ $errors->has('slug') ? 'border-red-300 focus-within:border-red-500 focus-within:ring-red-100' : 'border-gray-200 focus-within:border-indigo-500 focus-within:ring-indigo-100' }}">
                <span class="pl-4 py-3 text-gray-400 select-none">/posts/</span>
                <input id="slug" type="text" wire:model="slug"
                    class="flex-1 min-w-0 px-1 py-3 bg-transparent outline-none">
            </div>
            @error('slug') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Excerpt --}}
        <div>
            <label for="excerpt" class="block mb-2 text-sm font-semibold text-gray-700">
                Excerpt <span class="font-normal text-gray-400">(optional)</span>
            </label>
            <textarea id="excerpt" rows="2" wire:model="excerpt" placeholder="A short summary..."
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 outline-none transition focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"></textarea>
            @error('excerpt') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Body --}}
        <div>
            <label for="body" class="block mb-2 text-sm font-semibold text-gray-700">Content</label>
            <textarea id="body" rows="14" wire:model="body" placeholder="Write your post..."
                class="w-full px-4 py-3 rounded-xl border bg-gray-50 outline-none transition focus:bg-white focus:ring-4
                {{ $errors->has('body') ? 'border-red-300 focus:border-red-500 focus:ring-red-100' : 'border-gray-200 focus:border-indigo-500 focus:ring-indigo-100' }}"></textarea>
            @error('body') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Status --}}
        <div>
            <span class="block mb-2 text-sm font-semibold text-gray-700">Status</span>
            <div class="grid grid-cols-2 gap-3">
                @foreach (['draft' => 'Draft', 'published' => 'Published'] as $value => $label)
                    <label class="flex items-center gap-3 px-4 py-3 rounded-xl border cursor-pointer transition
                        {{ $status === $value ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-gray-200 hover:bg-gray-50' }}">
                        <input type="radio" wire:model.live="status" value="{{ $value }}"
                            class="text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm font-medium">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            @error('status') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('posts.index') }}" wire:navigate
                class="px-4 py-2.5 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 transition">
                Cancel
            </a>

            <button type="submit" wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-lg shadow-indigo-600/25 transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 disabled:opacity-60">
                <x-lucide-save class="w-4 h-4" wire:loading.remove wire:target="save" />
                <x-lucide-loader-circle class="w-4 h-4 animate-spin" wire:loading wire:target="save" />
                {{ $post?->exists ? 'Update post' : 'Create post' }}
            </button>
        </div>
    </form>
</div>