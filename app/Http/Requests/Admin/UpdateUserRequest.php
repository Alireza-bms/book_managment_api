<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ensure the admin has permission to update users
        return $this->user()->can('admin.users.update');
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $this->user->id,
            'password' => 'sometimes|string|min:6',
            'roles' => 'sometimes|array',
            'roles.*' => 'exists:roles,name',
        ];
    }
}
