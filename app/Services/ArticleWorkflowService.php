<?php

namespace App\Services;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ArticleWorkflowService
{

    public function submitForReview(User $user, Article $article): Article
    {
        Gate::forUser($user)->authorize('submitReview', $article);

        $article->update([
            'status' => 'review',
            'published_at' => null,
            'revision_notes' => null,
        ]);

        return $article->refresh();
    }

    public function approve(User $user, Article $article): Article
    {
        Gate::forUser($user)->authorize('approve', $article);

        $article->update([
            'status' => 'approved',
            'published_at' => null,
        ]);

        return $article->refresh();
    }

    public function returnForRevision(
        User $user,
        Article $article,
        string $revisioNotes
    ): Article {
        Gate::forUser($user)->authorize(
            'returnForRevision',
            $article
        );

        $validated = Validator::make(
            ['revision_notes' => trim($revisioNotes)],
            [
                'revision_notes' => [
                    'required',
                    'string',
                    'max:2000',
                ],
            ]
        )->validate();

        $article->update([
            'status' => 'draft',
            'revision_notes' => $validated['revision_notes'],
            'published_at' => null,
        ]);

        return $article->refresh();
    }

    public function publish(User $user, Article $article): Article
    {
        Gate::forUser($user)->authorize('publish', $article);

        $article->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return $article->refresh();
    }
}
