<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimplePostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'slug'           => $this->slug,
            'title'          => $this->title,
            'excerpt'        => $this->excerpt,
            'featured_image' => ImageResource::make($this->featuredImage),
            'published_at'   => $this->published_at,
            'authors'        => AuthorResource::collection($this->whenLoaded('authors')),
        ];
    }
}
