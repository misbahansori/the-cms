<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Misbah Ansori',
            'email'    => 'misbah.ansori24@gmail.com',
        ]);
    }
}
