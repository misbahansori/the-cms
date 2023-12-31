<?php

namespace Database\Seeders;

use App\Models\Flag;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::create([
            'slug' => 'belajarai',
            'name' => 'belajarai',
        ]);

        $misbah = User::create([
            'name'     => 'Misbah Ansori',
            'slug'     => 'misbah-ansori',
            'email'    => 'misbah.ansori24@gmail.com',
            'password' => bcrypt('password')
        ]);

        $misbah->flag(Flag::ADMIN);

        $bowo = User::create([
            'name'     => 'Firdaus Wibowo',
            'slug'     => 'firdaus-wibowo',
            'email'    => 'bowo@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $bowo->flag(Flag::ADMIN);

        $tenant->users()->attach($misbah);
        $tenant->users()->attach($bowo);
    }
}
