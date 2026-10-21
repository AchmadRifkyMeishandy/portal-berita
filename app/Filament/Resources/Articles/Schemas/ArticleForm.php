<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Models\Article;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('author_id')
                    ->relationship(
                        name: 'author',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query) => $query->role('journalist'),
                    )
                    ->searchable()
                    ->required(),

                Select::make('categories')
                    ->relationship(
                        name: 'categories',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query): Builder => $query->where('is_active', true),
                    )
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),

                Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->required(),

                Textarea::make('excerpt')
                    ->maxLength(300)
                    ->columnSpanFull(),

                Textarea::make('revision_notes')
                    ->label('Revision Notes from Editor')
                    ->disabled()
                    ->dehydrated(false)
                    ->rows(4)
                    ->columnSpanFull()
                    ->visible(
                        fn(?Article $record): bool => filled($record?->revision_notes)
                    ),

                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('featured_image')
                    ->image()
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                    ])
                    ->maxSize(5120)
                    ->disk('public')
                    ->directory('articles')
                    ->visibility('public')
                    ->imageAspectRatio('16:9')
                    ->automaticallyOpenImageEditorForAspectRatio()
                    ->columnSpanFull()
                    ->helperText('JPEG, PNG, WebP. Maksimal 5 MB.'),

                Toggle::make('is_featured')
                    ->required(),

                Toggle::make('is_breaking')
                    ->required(),

                TextInput::make('reading_time_minutes')
                    ->numeric(),

                TextInput::make('meta_title'),

                Textarea::make('meta_description')
                    ->columnSpanFull(),

            ]);
    }
}
