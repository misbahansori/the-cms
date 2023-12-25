<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'slug'           => $this->slug,
            'title'          => $this->title,
            'excerpt'        => $this->excerpt,
            'content'        => $this->content,
            'featured_image' => $this->featuredImage,
            'published_at'   => $this->published_at,
            'created_at'     => $this->created_at,
        ];
    }
}
