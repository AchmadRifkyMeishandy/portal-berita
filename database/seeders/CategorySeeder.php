<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Liga Indonesia',
                'slug' => 'liga-indonesia',
                'description' => 'Berita sepak bola Indonesia.',
                'parent_id' => null,
                'sort_order' => 1,
            ],
            [
                'name' => 'Liga Inggris',
                'slug' => 'liga-inggris',
                'description' => 'Berita sepak bola Inggris dan Premier League.',
                'parent_id' => null,
                'sort_order' => 2,
            ],
            [
                'name' => 'La Liga',
                'slug' => 'la-liga',
                'description' => 'Berita sepak bola Spanyol.',
                'parent_id' => null,
                'sort_order' => 3,
            ],
            [
                'name' => 'Serie A',
                'slug' => 'serie-a',
                'description' => 'Berita sepak bola Italia.',
                'parent_id' => null,
                'sort_order' => 4,
            ],
            [
                'name' => 'Timnas Indonesia',
                'slug' => 'timnas-indonesia',
                'description' => 'Berita Tim Nasional Indonesia.',
                'parent_id' => null,
                'sort_order' => 5,
            ],
            [
                'name' => 'Transfer',
                'slug' => 'transfer',
                'description' => 'Berita transfer dan bursa pemain.',
                'parent_id' => null,
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
