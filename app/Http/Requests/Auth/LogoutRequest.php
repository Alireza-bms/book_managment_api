<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LogoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required|in:current,all,specific',
            'token_id' => 'nullable|integer|required_if:type,specific',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'The logout type is required.',
            'type.in' => 'Type must be one of: current, all, specific.',
            'token_id.required_if' => 'Token ID is required when type is "specific".',
            'token_id.integer' => 'Token ID must be an integer.',
        ];
    }
}
