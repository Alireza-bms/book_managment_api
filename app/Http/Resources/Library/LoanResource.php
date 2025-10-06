<?php

namespace App\Http\Resources\Library;

use App\Http\Resources\Admin\UserResource;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/** @mixin Loan */
class LoanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'status'      => $this->status,
            'loaned_at'   => $this->loaned_at,
            'due_at'      => $this->due_at,
            'returned_at' => $this->returned_at,

            'user' => BookResource::make($this->whenLoaded('user')),
            'book' => BookResource::make($this->whenLoaded('book')),
        ];
    }
}
