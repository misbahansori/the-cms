<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use FilamentTiptapEditor\TiptapFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $title =  fake()->sentence,
            'slug' => Str::slug($title),
            'excerpt' => fake()->sentence,
            'content' => TiptapFaker::make()
                ->heading()
                ->paragraphs(rand(1, 5))
                ->heading(2)
                ->paragraphs(rand(3, 5))
                ->heading(2)
                ->paragraphs(rand(3, 5))
                ->asHTML(),
            'published_at' => rand(0, 1) ? now()->addDays(15)->subDays(rand(1, 30)) : null
        ];
    }

    public function published(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => now(),
            ];
        });
    }

    public function scheduled(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => now()->addDays(rand(1, 30)),
            ];
        });
    }

    public function draft(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => null,
            ];
        });
    }
}
