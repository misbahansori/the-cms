<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug'        => $this->slug,
            'name'        => $this->name,
            'description' => $this->description,
            'posts_count' => $this->whenCounted('posts'),
            'seo'         => SeoResource::make($this->whenLoaded('seo')),
        ];
    }
}
