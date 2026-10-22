<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $topics = [
            'Persija Jakarta',
            'Timnas Indonesia',
            'Liga 1',
            'Premier League',
            'Transfer Pemain',
            'Liga Champions',
        ];

        $topic = fake()->randomElement($topics);
        $title = "{$topic} " . fake()->sentence(6);

        return [
            'author_id' => null,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 999999),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(8, true),
            'featured_image' => null,
            'status' => 'draft',
            'is_featured' => false,
            'is_breaking' => false,
            'views_count' => 0,
            'reading_time_minutes' => fake()->numberBetween(2, 10),
            'meta_title' => $title,
            'meta_description' => fake()->sentence(15),
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function breaking(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_breaking' => true,
        ]);
    }
}
