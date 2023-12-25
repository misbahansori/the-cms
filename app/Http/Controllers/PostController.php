<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\SimplePostResource;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();

        return SimplePostResource::collection($posts);
    }

    public function show(Tenant $tenant, string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return PostResource::make($post);
    }
}
