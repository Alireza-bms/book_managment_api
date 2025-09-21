<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'is_email_verified' => (bool) $this->email_verified_at,
            // Count of loans (preloaded with loadCount in controller)
            'loans_count' => $this->loans_count,
        ];
    }
}
