{{-- resources/views/posts/_form.blade.php --}}
{{-- Shared by create and edit. Expects: $post, $action, $submit --}}
<form method="POST" action="{{ $action }}">
    @csrf
    @if ($post->exists)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main column --}}
        <x-ui.card class="lg:col-span-2 p-6 sm:p-8 space-y-6">
            <x-ui.input name="title" label="Title" icon="type" placeholder="Post title"
                :value="$post->title" required autofocus />

            <x-ui.textarea name="excerpt" label="Excerpt" rows="3"
                placeholder="A short summary shown in listings..."
                hint="Optional. Max 500 characters." :value="$post->excerpt" />

            <x-ui.textarea name="body" label="Content" rows="14"
                placeholder="Write your post..." :value="$post->body" required />
        </x-ui.card>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <x-ui.card class="p-6 space-y-6">
                <div>
                    <span class="block mb-2 text-sm font-semibold text-gray-700">Status</span>

                    <div class="space-y-2">
                        @foreach (['draft' => ['Draft', 'file-pen-line'], 'published' => ['Published', 'globe']] as $value => [$label, $icon])
                            <label class="flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-200 cursor-pointer transition hover:bg-gray-50
                                has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-700">
                                <input type="radio" name="status" value="{{ $value }}"
                                    @checked(old('status', $post->status) === $value)
                                    class="text-indigo-600 focus:ring-indigo-500">
                                <x-dynamic-component :component="'lucide-' . $icon" class="w-4 h-4" />
                                <span class="text-sm font-medium">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('status')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <x-ui.input name="slug" label="Slug" icon="link-2" placeholder="auto-generated"
                    hint="Leave empty to generate from the title." :value="$post->slug" />
            </x-ui.card>

            <div class="flex items-center gap-3">
                <x-ui.button type="submit" icon="save" class="flex-1">{{ $submit }}</x-ui.button>
                <x-ui.button :href="route('posts.index')" variant="secondary">Cancel</x-ui.button>
            </div>
        </div>
    </div>
</form>