<?php

namespace App\Http\Requests\Library;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')->id;

        return [
            'name' => "sometimes|required|string|max:255|unique:categories,name,$categoryId",
            'description' => 'sometimes|nullable|string',
            'book_ids' => 'sometimes|array',
            'book_ids.*' => 'exists:books,id',
        ];
    }
}
