<?php

namespace App\Filament\Resources\Articles\Pages;

use Filament\Facades\Filament;
use App\Filament\Resources\Articles\ArticleResource;
use App\Models\Article;
use App\Models\User;
use App\Services\ArticleWorkflowService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Textarea;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('submitForReview')
                ->label('Submit for Review')
                ->color('info')
                ->requiresConfirmation()
                ->modalHeading('submit article for review')
                ->modalDescription('The article status will change from draft to review.')
                ->visible(function (): bool {
                    $user = Filament::auth()->user();
                    $article = $this->getRecord();

                    if (! ($user instanceof User)) {
                        return false;
                    }

                    if (! ($article instanceof Article)) {
                        return false;
                    }

                    return $user->can('submitReview', $article);
                })
                ->action(function (): void {
                    $user = Filament::auth()->user();

                    if (! ($user instanceof User)) {
                        abort(403);
                    }
                    $article = $this->getRecord();

                    if (! ($article instanceof Article)) {
                        abort(404);
                    }

                    app(ArticleWorkflowService::class)
                        ->submitForReview($user, $article);

                    Notification::make()
                        ->title('Article submitted for review')
                        ->success()
                        ->send();
                }),

            Action::make('approveArticle')
                ->label('Approve Article')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Approve article')
                ->modalDescription('The article status will change from review to approved.')
                ->visible(function (): bool {
                    $user = Filament::auth()->user();
                    $article = $this->getRecord();

                    if (! ($user instanceof User)) {
                        return false;
                    }

                    if (! ($article instanceof Article)) {
                        return false;
                    }

                    return $user->can('approve', $article);
                })
                ->action(function (): void {
                    $user = Filament::auth()->user();

                    if (! ($user instanceof User)) {
                        abort(403);
                    }

                    $article = $this->getRecord();

                    if (! ($article instanceof Article)) {
                        abort(404);
                    }

                    app(ArticleWorkflowService::class)
                        ->approve($user, $article);

                    Notification::make()
                        ->title('Article approved successfully')
                        ->success()
                        ->send();
                }),

            Action::make('returnForRevision')
                ->label('Return for Revision')
                ->color('warning')
                ->schema([
                    Textarea::make('revision_notes')
                        ->label('Revision Notes')
                        ->placeholder(
                            'Explain what the journalist needs to revise...'
                        )
                        ->required()
                        ->maxLength(2000)
                        ->rows(5)
                        ->columnSpanFull(),
                ])
                ->modalHeading('Return Article for Revision')
                ->modalDescription(
                    'The article will return to draft. The journalist will see your notes.'
                )
                ->modalSubmitActionLabel('Return for Revision')
                ->visible(function (): bool {
                    $user = Filament::auth()->user();
                    $article = $this->getRecord();

                    if (! ($user instanceof User)) {
                        return false;
                    }

                    if (! ($article instanceof Article)) {
                        return false;
                    }

                    return $user->can('returnForRevision', $article);
                })
                ->action(function (array $data): void {
                    $user = Filament::auth()->user();

                    if (! ($user instanceof User)) {
                        abort(403);
                    }

                    $article = $this->getRecord();

                    if (! ($article instanceof Article)) {
                        abort(404);
                    }

                    app(ArticleWorkflowService::class)
                        ->returnForRevision(
                            $user,
                            $article,
                            $data['revision_notes'],
                        );

                    Notification::make()
                        ->title('Article returned for revision')
                        ->success()
                        ->send();
                }),

            Action::make('publishArticle')
                ->label('Publish Article')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Publish article')
                ->modalDescription('The article status will change from approved to published. ')
                ->visible(function (): bool {
                    $user = Filament::auth()->user();
                    $article = $this->getRecord();

                    if (! ($user instanceof User)) {
                        return false;
                    }

                    if (! ($article instanceof Article)) {
                        return false;
                    }

                    return $user->can('publish', $article);
                })
                ->action(function (): void {
                    $user = Filament::auth()->user();

                    if (! ($user instanceof User)) {
                        abort(403);
                    }

                    $article = $this->getRecord();

                    if (! ($article instanceof Article)) {
                        abort(404);
                    }

                    app(ArticleWorkflowService::class)
                        ->publish($user, $article);

                    Notification::make()
                        ->title('Article published successfully')
                        ->success()
                        ->send();
                }),

            DeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
