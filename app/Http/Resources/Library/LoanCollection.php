<?php

namespace App\Http\Resources\Library;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LoanCollection extends ResourceCollection
{
    public function toArray(Request $request): AnonymousResourceCollection
    {
        return LoanResource::collection($this->collection);
    }
}
