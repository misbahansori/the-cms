<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedInclude;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'integer|min:1|max:100',
        ]);

        $perPage = request('per_page', 15);

        $categories = QueryBuilder::for(Category::class)
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
            ->paginate();


        return CategoryResource::collection($categories);
    }

    public function show(Tenant $tenant, string $slug)
    {
        $category = QueryBuilder::for(Category::class)
            ->allowedIncludes([
                'seo',
                AllowedInclude::count('posts_count', 'posts')
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        return CategoryResource::make($category);
    }
}
