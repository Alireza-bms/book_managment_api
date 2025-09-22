<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('admin.permissions.store');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:permissions,name',
        ];
    }
}
