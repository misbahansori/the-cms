<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\UserResource\Pages\EditUser;
use App\Filament\Admin\Resources\UserResource\Pages\ListUsers;
use App\Filament\Admin\Resources\UserResource\Pages\CreateUser;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Grid::make()
                    ->schema([
                        DateTimePicker::make('email_verified_at'),
                        TextInput::make('password')
                            ->password()
                            ->required(fn ($context) => $context === 'create')
                            ->confirmed()
                            ->maxLength(255),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->required(fn ($context) => $context === 'create')
                            ->dehydrated(false)
                            ->maxLength(255),
                        Select::make('tenants')
                            ->relationship('tenants', 'name')
                            ->multiple()
                            ->preload(),
                    ]),
                Grid::make()
                    ->columns(2)
                    ->schema([
                        Repeater::make('flags')
                            ->relationship('flags')
                            ->label('Admin Flags')
                            ->addActionLabel('Add Admin Flag')
                            ->schema([
                                Select::make('name')
                                    ->reactive()
                                    ->required()
                                    ->options([
                                        'admin'  => 'Admin',
                                        'author' => 'Author',
                                    ]),
                            ])
                            ->columnSpan(1),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->description(fn ($record) => $record->email)
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query
                                ->where('name', 'like', "%$search%")
                                ->orWhere('email', 'like', "%$search%");
                        }
                    ),
                TextColumn::make('flags.name')
                    ->badge(),
                TextColumn::make('tenants.name')
                    ->badge()
            ])
            ->filters([
                SelectFilter::make('tenants')
                    ->relationship('tenants', 'name')
                    ->searchable()
                    ->preload()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
            // 'change-password' => Pages\ChangePassword::route('/change-password'),
            // 'merge-users' => Pages\MergeUsers::route('/merge-users'),
        ];
    }
}
