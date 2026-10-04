<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Persija', 'slug' => 'persija'],
            ['name' => 'Persib', 'slug' => 'persib'],
            ['name' => 'Timnas Indonesia', 'slug' => 'timnas-indonesia'],
            ['name' => 'Transfer', 'slug' => 'transfer'],
            ['name' => 'Liga 1', 'slug' => 'liga-1'],
            ['name' => 'Premier League', 'slug' => 'premier-league'],
            ['name' => 'Champions League', 'slug' => 'champions-league'],
            ['name' => 'Pemain Baru', 'slug' => 'pemain-baru'],
            ['name' => 'Pelatih', 'slug' => 'pelatih'],
            ['name' => 'Timnas', 'slug' => 'timnas'],
        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate(
                ['slug' => $tag['slug']],
                $tag
            );
        }
    }
}
