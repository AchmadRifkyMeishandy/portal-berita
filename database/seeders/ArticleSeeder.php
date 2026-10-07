<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use RuntimeException;

use function PHPUnit\Framework\throwException;

class ArticleSeeder extends Seeder
{
    private const TOTAL_ARTICLES = 100;
    private const PUBLISHED_ARTICLES = 60;
    private const DRAFT_ARTICLES = 25;
    private const REVIEW_ARTICLES = 15;
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
            throw new RuntimeException('No journalist users found.');
        }

        if ($categories->isEmpty() || $tags->isEmpty()) {
            throw new RuntimeException('No active categories found.');
        }

        $articles = Article::factory()
            ->count(self::TOTAL_ARTICLES)
            ->state(fn() => [
                'author_id' => $authors->random()->id,
            ])
            ->state(new Sequence(
                fn(Sequence $sequence) => match (true) {
                    $sequence->index < self::PUBLISHED_ARTICLES => [
                        'status' => 'published',
                        'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
                    ],

                    $sequence->index < self::PUBLISHED_ARTICLES + self::DRAFT_ARTICLES => [
                        'status' => 'draft',
                        'published_at' => null,
                    ],

                    default => [
                        'status' => 'review',
                        'published_at' => null,
                    ],
                }
            ))
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
