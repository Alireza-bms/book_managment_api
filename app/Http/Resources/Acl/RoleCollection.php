<?php

namespace App\Http\Resources\Acl;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \Spatie\Permission\Models\Role */
class RoleCollection extends ResourceCollection
{
    public function toArray(Request $request): AnonymousResourceCollection
    {
        return RoleResource::collection($this->collection);
    }
}
