<?php

namespace App\Filament\Tenant\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use RalphJSmit\Filament\SEO\SEO;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Tenant\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Tenant\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Tenant\Resources\CategoryResource\Pages\ListCategories;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $navigationParentItem = 'Posts';

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
                                    ->schema([
                                        Grid::make()
                                            ->schema([
                                                Select::make('parent_id')
                                                    ->relationship('parent', 'name')
                                                    ->label('Parent Category')
                                                    ->preload()
                                                    ->searchable()
                                            ])
                                            ->columnSpanFull(),
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('slug')
                                            ->slug(source: 'name')
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('description')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('SEO')
                                    ->columnSpan(2)
                                    ->schema([
                                        SEO::make(),
                                    ])
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->description(fn (Category $record) => $record->slug)
                    ->sortable()
                    ->searchable(['name', 'slug']),
                TextColumn::make('parent.name')
                    ->label('Parent Category')
                    ->sortable(),
                TextColumn::make('description')
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
