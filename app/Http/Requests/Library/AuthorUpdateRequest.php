<?php

namespace App\Http\Requests\Library;

use Illuminate\Foundation\Http\FormRequest;

class AuthorUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'bio' => 'sometimes|nullable|string',
            'book_ids' => 'sometimes|array',
            'book_ids.*' => 'exists:books,id',
        ];
    }
}
