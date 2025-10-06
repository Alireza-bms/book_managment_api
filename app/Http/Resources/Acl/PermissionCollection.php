<?php

namespace App\Http\Resources\Acl;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \Spatie\Permission\Models\Permission */
class PermissionCollection extends ResourceCollection
{
    public function toArray(Request $request): AnonymousResourceCollection
    {
        return PermissionResource::collection($this->collection);
    }
}
