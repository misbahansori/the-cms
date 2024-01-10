<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\SimplePostResource;

class PostController extends Controller
{
    public function index(Tenant $tenant, Request $request)
    {
        $request->validate([
            'per_page' => 'integer|min:1|max:100',
        ]);

        $perPage = $request->get('per_page', 10);

        $posts = QueryBuilder::for(Post::class)
            ->allowedIncludes(['authors', 'featuredImage', 'seo', 'categories', 'tags'])
            ->allowedSorts(['title', 'published_at', 'created_at', 'updated_at'])
            ->paginate($perPage);

        return SimplePostResource::collection($posts);
    }

    public function show(Tenant $tenant, string $id)
    {
        $post = QueryBuilder::for(Post::class)
            ->allowedIncludes(['authors', 'featuredImage', 'seo', 'categories', 'tags'])
            ->where('id', $id)
            ->firstOrFail();

        return PostResource::make($post);
    }
}
