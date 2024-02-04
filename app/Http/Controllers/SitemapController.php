<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Tenant;
use App\Models\Category;
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
            'posts'      => $this->getPosts($request),
            'tags'       => $this->getTags($request),
            'categories' => $this->getCategories($request),
            default      => abort(404),
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


    protected function getTags(Request $request)
    {
        $perPage = $request->get('per_page', 100);

        $tags = QueryBuilder::for(Tag::class)
            ->select('id', 'slug', 'updated_at')
            ->paginate($perPage);

        return $tags;
    }

    protected function getCategories(Request $request)
    {
        $perPage = $request->get('per_page', 100);

        $categories = QueryBuilder::for(Category::class)
            ->select('id', 'slug', 'updated_at')
            ->paginate($perPage);

        return $categories;
    }
}
