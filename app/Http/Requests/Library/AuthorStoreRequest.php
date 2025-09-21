<?php

namespace App\Http\Requests\Library;

use Illuminate\Foundation\Http\FormRequest;

class AuthorStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'book_ids' => 'nullable|array',
            'book_ids.*' => 'exists:books,id',
        ];
    }
}
