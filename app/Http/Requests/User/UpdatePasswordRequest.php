<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the authenticated user is authorized to update their password.
     */
    public function authorize(): bool
    {
        // Only authenticated users can update their password
        return $this->user() !== null;
    }

    /**
     * Get the validation rules for updating password.
     */
    public function rules(): array
    {
        return [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed', // new_password_confirmation must match
        ];
    }
}
