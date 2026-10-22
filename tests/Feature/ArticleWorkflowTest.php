<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use App\Services\ArticleWorkflowService;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Validation\ValidationException;

class ArticleWorkflowTest extends TestCase
{
    use RefreshDatabase;


    public function test_journalist_can_submit_own_draft_article_for_review(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $journalist = User::factory()->create();

        $journalist->assignRole('journalist');

        $article = Article::factory()->create([
            'author_id' => $journalist->id,
            'status' => 'draft',
            'revision_notes' => 'Please revise the introduction.',
            'published_at' => null,
        ]);

        $workflow = app(ArticleWorkflowService::class);

        $updatedArticle = $workflow->submitForReview(
            $journalist,
            $article,
        );

        $this->assertSame('review', $updatedArticle->status);

        $this->assertNull($updatedArticle->revision_notes);

        $this->assertNull($updatedArticle->published_at);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'status' => 'review',
            'revision_notes' => null,
            'published_at' => null,
        ]);
    }

    public function test_journalist_cannot_submit_another_journalists_article(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $owner = User::factory()->create();
        $owner->assignRole('journalist');

        $otherJournalist = User::factory()->create();
        $otherJournalist->assignRole('journalist');

        $article = Article::factory()->create([
            'author_id' => $owner->id,
            'status' => 'draft',
            'published_at' => null,
        ]);

        $workflow = app(ArticleWorkflowService::class);

        try {
            $workflow->submitForReview(
                $otherJournalist,
                $article,
            );

            $this->fail(
                'A journalist must not submit another journalist\'s article.'
            );
        } catch (AuthorizationException) {
            // Tindakan ditolak sesuai aturan otorisasi.
        }

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'status' => 'draft',
        ]);
    }

    public function test_editor_can_approve_article_under_review(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $journalist = User::factory()->create();
        $journalist->assignRole('journalist');

        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $article = Article::factory()->create([
            'author_id' => $journalist->id,
            'status' => 'review',
            'published_at' => null,
        ]);

        $workflow = app(ArticleWorkflowService::class);

        $approvedArticle = $workflow->approve(
            $editor,
            $article,
        );

        $this->assertSame('approved', $approvedArticle->status);

        $this->assertNull($approvedArticle->published_at);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'status' => 'approved',
            'published_at' => null,
        ]);
    }

    public function test_editor_can_publish_approved_article(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $journalist = User::factory()->create();
        $journalist->assignRole('journalist');

        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $article = Article::factory()->create([
            'author_id' => $journalist->id,
            'status' => 'approved',
            'published_at' => null,
        ]);

        $workflow = app(ArticleWorkflowService::class);

        $publishedArticle = $workflow->publish(
            $editor,
            $article
        );

        $this->assertSame('published', $publishedArticle->status);

        $this->assertNotNull($publishedArticle->published_at);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'status' => 'published',
        ]);

        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
            'published_at' => null,
        ]);
    }

    public function test_editor_can_return_article_for_revision(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $journalist = User::factory()->create();
        $journalist->assignRole('journalist');

        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $article = Article::factory()->create([
            'author_id' => $journalist->id,
            'status' => 'review',
            'revision_notes' => null,
            'published_at' => null,
        ]);

        $revisionNotes = 'Please improve the introduction.';

        $workflow = app(ArticleWorkflowService::class);

        $updatedArticle = $workflow->returnForRevision(
            $editor,
            $article,
            $revisionNotes,
        );

        $this->assertSame('draft', $updatedArticle->status);

        $this->assertSame(
            $revisionNotes,
            $updatedArticle->revision_notes,
        );

        $this->assertNull($updatedArticle->published_at);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'status' => 'draft',
            'revision_notes' => $revisionNotes,
            'published_at' => null,
        ]);
    }

    public function test_journalist_cannot_approve_article_under_review(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $journalist = User::factory()->create();
        $journalist->assignRole('journalist');

        $article = Article::factory()->create([
            'author_id' => $journalist->id,
            'status' => 'review',
            'published_at' => null,
        ]);

        $workflow = app(ArticleWorkflowService::class);

        try {
            $workflow->approve($journalist, $article);

            $this->fail(
                'A journalist must not be able to approve an article.'
            );
        } catch (AuthorizationException) {
            // Expected: the journalist does not have permission to approve.
        }

        $this->assertSame('review', $article->fresh()->status);
        $this->assertNull($article->fresh()->published_at);
    }

    public function test_editor_cannot_return_article_with_empty_revision_notes(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $journalist = User::factory()->create();
        $journalist->assignRole('journalist');

        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $article = Article::factory()->create([
            'author_id' => $journalist->id,
            'status' => 'review',
            'revision_notes' => null,
            'published_at' => null,
        ]);

        $workflow = app(ArticleWorkflowService::class);

        try {
            $workflow->returnForRevision($editor, $article, '');

            $this->fail(
                'Empty revision notes must not be accepted.'
            );
        } catch (ValidationException) {
            // Expected: empty revision notes are invalid.
        }

        $article->refresh();

        $this->assertSame('review', $article->status);
        $this->assertNull($article->revision_notes);
        $this->assertNull($article->published_at);
    }
}
