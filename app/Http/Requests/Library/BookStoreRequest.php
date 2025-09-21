<?php

namespace App\Http\Requests\Library;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'isbn' => 'required|string|unique:books,isbn|max:255',
            'published_year' => 'nullable|digits:4|integer',
            'category_id' => 'required|exists:categories,id',
            'total_copies' => 'nullable|integer|min:1',
            'available_copies' => 'nullable|integer|min:0',
            'author_ids' => 'required|array|min:1',
            'author_ids.*' => 'exists:authors,id',
        ];
    }
}
