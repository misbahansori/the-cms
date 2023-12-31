<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'url'           => $this->url,
            'width'         => $this->width,
            'height'        => $this->height,
            'title'         => $this->title,
            'alt'           => $this->alt,
            'caption'       => $this->caption,
            'description'   => $this->description,
            'thumbnail_url' => url($this->thumbnail_url),
        ];
    }
}
