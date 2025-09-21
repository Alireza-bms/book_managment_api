<?php

namespace App\Http\Requests\Library;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bookId = $this->route('book')->id;

        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'isbn' => "sometimes|required|string|max:255|unique:books,isbn,$bookId",
            'published_year' => 'sometimes|nullable|digits:4|integer',
            'category_id' => 'sometimes|required|exists:categories,id',
            'total_copies' => 'sometimes|integer|min:1',
            'available_copies' => 'sometimes|integer|min:0',
            'author_ids' => 'sometimes|required|array|min:1',
            'author_ids.*' => 'exists:authors,id',
        ];
    }
}
