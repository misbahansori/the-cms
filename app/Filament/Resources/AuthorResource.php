<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Author;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use RalphJSmit\Filament\SEO\SEO;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\AuthorResource\Pages;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use App\Filament\Resources\AuthorResource\RelationManagers;

class AuthorResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Author';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $tenantOwnershipRelationshipName = 'tenants';

    protected static ?string $navigationGroup = 'Author';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->placeholder('Name')
                    ->label('Name'),
                TextInput::make('slug')
                    ->required()
                    ->placeholder('Slug')
                    ->helperText('This will be used as the author slug in the URL.')
                    ->label('Slug')
                    ->suffixAction(
                        fn (): Action  =>  Action::make('generate_slug')
                            ->icon('heroicon-o-arrow-path')
                            ->tooltip('Generate Slug')
                            ->color('success')
                            ->action(function (Get $get, Set $set) {
                                $title = $get('name');
                                $set('slug', Str::slug($title));
                            }),
                    ),
                CuratorPicker::make('avatar_id')
                    ->label('Avatar'),
                TextInput::make('email')
                    ->required()
                    ->placeholder('Email')
                    ->label('Email'),
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('password')
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->label('New Password')
                            ->password()
                            ->confirmed()
                            ->minLength(6)
                            ->helperText('Leave it blank, if you don\'t want change the password.'),
                        TextInput::make('password_confirmation')
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->label('New Password Confirmation')
                            ->password()
                            ->dehydrated(false),
                    ]),
                SEO::make(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CuratorColumn::make('avatar_id')
                    ->width(80)
                    ->height(80)
                    ->circular(),
                TextColumn::make('name')
                    ->label('Author Name')
                    ->description(fn (User $record) => $record->slug)
                    ->searchable([
                        'name',
                        'slug',
                    ])
                    ->sortable(),
                TextColumn::make('flags.name')
                    ->label('Roles')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin'  => 'info',
                        'author' => 'warning',
                    }),
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
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }
}
