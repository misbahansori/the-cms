<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\SeoResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\AuthorResource;
use RalphJSmit\Laravel\SEO\TagManager;
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
            'published_at'   => $this->published_at,
            'featured_image' => ImageResource::make($this->featuredImage),
            'authors'        => AuthorResource::collection($this->whenLoaded('authors')),
            'seo'            => SeoResource::make($this->whenLoaded('seo')),
            'categories'     => SimpleCategoryResource::collection($this->whenLoaded('categories')),
            'tags'           => SimpleTagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
