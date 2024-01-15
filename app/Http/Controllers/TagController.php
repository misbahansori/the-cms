<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedInclude;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'integer|min:1|max:100',
        ]);

        $perPage = request('per_page', 15);

        $tags = QueryBuilder::for(Tag::class)
            ->allowedFilters([
                'name',
                'slug'
            ])
            ->allowedIncludes([
                'seo',
                AllowedInclude::count('posts_count', 'posts')
            ])
            ->allowedSorts([
                'name',
                'slug',
                'posts_count',
            ])
            ->paginate($perPage);

        return TagResource::collection($tags);
    }

    public function show(Tenant $tenant, string $slug)
    {
        $tag = QueryBuilder::for(Tag::class)
            ->allowedIncludes([
                'seo',
                AllowedInclude::count('posts_count', 'posts')
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        return TagResource::make($tag);
    }
}
