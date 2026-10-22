<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('articles.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article): bool
    {
        return $user->can('articles.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('articles.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
        if (! $user->can('articles.update')) {
            return false;
        }

        if ($user->can('articles.review')) {
            return true;
        }

        return $article->author_id === $user->id && $article->status === 'draft';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        return $user->can('articles.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Article $article): bool
    {
        return $user->can('articles.restore') && $article->trashed();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Article $article): bool
    {
        return false;
    }

    public function submitReview(User $user, Article $article): bool
    {
        return $user->can('articles.submit_review')
            && $article->author_id === $user->id
            && $article->status === 'draft';
    }

    public function approve(User $user, Article $article): bool
    {
        return $user->can('articles.review')
            && $article->status === 'review';
    }

    public function publish(User $user, Article $article): bool
    {
        return $user->can('articles.publish')
            && $article->status === 'approved';
    }

    public function returnForRevision(
        User $user,
        Article $article
    ): bool {
        return $user->can('articles.review') && $article->status === 'review';
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('articles.delete');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('articles.restore');
    }

    public function forceDeleteAny(User $user): bool
    {
        return false;
    }
}
