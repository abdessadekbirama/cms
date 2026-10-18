<?php
// app/Http/Requests/PostRequest.php
// Used for both store and update.

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ownership is checked with Gate in the controller
    }

    // Slug is optional in the form: build it from the title when empty
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: (string) $this->input('title')),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required', 'string', 'max:255',
                Rule::unique('posts', 'slug')->ignore($this->route('post')),
            ],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ];
    }
}