<?php

namespace App\Http\Resources\Library;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Book */
class BookCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return AnonymousResourceCollection
     */
    public function toArray(Request $request): AnonymousResourceCollection
    {
        return BookResource::collection($this->collection);
    }
}
