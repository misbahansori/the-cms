<?php

namespace App\Filament\Tenant\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use RalphJSmit\Filament\SEO\SEO;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
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
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
