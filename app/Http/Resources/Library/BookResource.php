<?php

namespace App\Http\Resources\Library;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Book
 */
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'isbn' => $this->isbn,
            'published_year' => $this->published_year,
            'authors' => AuthorCollection::make($this->whenLoaded('authors')),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'total_copies' => $this->total_copies,
            'available_copies' => $this->available_copies,
        ];
    }
}
