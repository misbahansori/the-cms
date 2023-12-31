<?php

namespace App\Filament\Tenant\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use App\Enums\Status;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use RalphJSmit\Filament\SEO\SEO;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use App\Filament\Tenant\Resources\PostResource\Pages\EditPost;
use App\Filament\Tenant\Resources\PostResource\Pages\ListPosts;
use App\Filament\Tenant\Resources\PostResource\Pages\CreatePost;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Articles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Grid::make(1)
                            ->columnSpan(2)
                            ->schema([
                                Section::make()
                                    ->columnSpan(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->hintIcon(
                                                'heroicon-m-question-mark-circle',
                                                tooltip: fn () => 'The slug should contain the seo keywords for the post.'
                                            )
                                            ->slug(source: 'title'),
                                        Textarea::make('excerpt')
                                            ->rows(3)
                                            ->required()
                                            ->reactive()
                                            ->helperText(function (?string $state): string {
                                                return (string) Str::of(strlen($state))
                                                    ->append(' / ')
                                                    ->append(160 . ' ')
                                                    ->append(Str::of(__('filament-seo::translations.characters'))->lower());
                                            })
                                            ->maxLength(160),
                                        CuratorPicker::make('featured_image_id')
                                            ->label('Featured Image')
                                            ->relationship('featuredImage', 'id'),
                                        TiptapEditor::make('content')
                                            ->required()
                                            ->columnSpanFull()
                                            ->extraInputAttributes(['style' => 'min-height: 12rem;']),
                                    ]),
                                Section::make('SEO')
                                    ->columnSpan(2)
                                    ->schema([
                                        SEO::make(),
                                    ]),
                            ]),
                        Grid::make(1)
                            ->columnSpan(1)
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Select::make('status')
                                            ->options(Status::class),
                                        DateTimePicker::make('published_at')
                                            ->nullable(),
                                        Select::make('authors')
                                            ->relationship('authors', 'name')
                                            ->preload()
                                            ->searchable()
                                            ->multiple()
                                    ]),
                                Section::make()
                                    ->label('Relationship')
                                    ->schema([
                                        Select::make('categories')
                                            ->relationship('categories', 'name')
                                            ->multiple()
                                            ->preload()
                                            ->createOptionAction(
                                                fn (Action $action) => $action->modalWidth('2xl')
                                            )
                                            ->createOptionForm([
                                                TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('slug')
                                                    ->slug(source: 'name')
                                                    ->required()
                                                    ->maxLength(255),
                                            ]),
                                        Select::make('tags')
                                            ->relationship('tags', 'name')
                                            ->multiple()
                                            ->preload()
                                            ->createOptionAction(
                                                fn (Action $action) => $action->modalWidth('2xl')
                                            )
                                            ->createOptionForm([
                                                TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('slug')
                                                    ->slug(source: 'name')
                                                    ->required()
                                                    ->maxLength(255),
                                            ]),
                                    ])
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CuratorColumn::make('featured_image_id')
                    ->label('Featured Image')
                    ->size(120),
                TextColumn::make('title')
                    ->limit(50)
                    ->description(fn (Post $record) => Str::limit($record->slug, 50))
                    ->sortable()
                    ->searchable(['title', 'slug']),
                TextColumn::make('excerpt')
                    ->wrap()
                    ->limit(100)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Review status')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('publish_status')
                    ->label('Publish status')
                    ->color(fn (Post $record) => match ($record->publish_status) {
                        Post::STATUS_DRAFT => 'gray',
                        Post::STATUS_PUBLISHED => 'success',
                        Post::STATUS_SCHEDULED => 'info',
                    })
                    ->tooltip(fn (Post $record) => $record->published_at?->format('d M Y H:i'))
                    ->badge()
                    ->toggleable(),
                TextColumn::make('authors.name')
                    ->label('Author')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Review status')
                    ->options(Status::class)
                    ->default(null),
                Filter::make('publish_status')
                    ->form([
                        Select::make('publish_status')
                            ->options([
                                'All' => 'All',
                                Post::STATUS_DRAFT => 'Draft',
                                Post::STATUS_PUBLISHED => 'Published',
                                Post::STATUS_SCHEDULED => 'Scheduled',
                            ])
                            ->default('All'),
                    ])
                    ->query(fn (Builder $query, $data) => match ($data['publish_status']) {
                        Post::STATUS_DRAFT => $query->whereNull('published_at'),
                        Post::STATUS_PUBLISHED => $query->whereNotNull('published_at')
                            ->where('published_at', '<=', now()),
                        Post::STATUS_SCHEDULED => $query->whereNotNull('published_at')
                            ->where('published_at', '>', now()),
                        default => $query,
                    }),
                SelectFilter::make('authors')
                    ->relationship('authors', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
