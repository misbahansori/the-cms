<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;

use Filament\Resources\Resource;
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
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
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
                                    ->required()
                                    ->helperText('The excerpt is a short summary of the post that will be displayed on the post card.')
                                    ->maxLength(160),
                                TiptapEditor::make('content')
                                    ->required()
                                    ->columnSpanFull()
                                    ->extraInputAttributes(['style' => 'min-height: 12rem;']),
                            ]),
                        Grid::make(1)
                            ->columnSpan(1)
                            ->schema([
                                Section::make()
                                    ->schema([
                                        DateTimePicker::make('published_at')
                                            ->nullable()
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
                TextColumn::make('title')
                    ->description(fn (Post $record) => $record->slug)
                    ->sortable()
                    ->searchable(['title', 'slug']),
                TextColumn::make('excerpt')
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
