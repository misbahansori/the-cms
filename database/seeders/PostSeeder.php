<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Database\Factories\PostFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::factory()
            ->count(30)
            ->create([
                'tenant_id' => 1
            ]);

        // assign random author with 1 or 2 id
        $posts->each(function ($post) {
            rand(0, 2) > 0 && $post->authors()->attach(rand(1, 2));
        });
    }
}
