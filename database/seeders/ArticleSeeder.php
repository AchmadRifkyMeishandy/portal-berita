<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = User::role('journalist')->get();

        $categories = Category::query()
            ->where('is_active', true)
            ->get();

        $tags = Tag::query()->get();

        if ($authors->isEmpty()) {
            return;
        }

        if ($categories->isEmpty() || $tags->isEmpty()) {
            return;
        }

        $articles = Article::factory()
            ->count(100)
            ->state(fn() => [
                'author_id' => $authors->random()->id,
            ])
            ->published()
            ->create();

        foreach ($articles as $article) {
            $article->categories()->sync(
                $categories
                    ->random(min(2, $categories->count()))
                    ->pluck('id')
                    ->all()
            );

            $article->tags()->sync(
                $tags->random(min(4, $tags->count()))
                    ->pluck('id')
                    ->all()
            );
        }
    }
}
