<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\SitemapResource;

class SitemapController extends Controller
{
    public function __invoke(Request $request, Tenant $tenant, string $type)
    {
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:1000',
        ]);

        $sitemap = match ($type) {
            'posts' => $this->getPosts($request),
            default => abort(404),
        };

        return SitemapResource::collection($sitemap);
    }

    protected function getPosts(Request $request)
    {
        $perPage = $request->get('per_page', 100);

        $posts = QueryBuilder::for(Post::class)
            ->select('id', 'slug', 'updated_at')
            ->paginate($perPage);

        return $posts;
    }
}
