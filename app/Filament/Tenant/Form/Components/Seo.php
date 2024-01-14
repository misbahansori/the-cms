<?php

namespace App\Filament\Tenant\Form\Components;

use Illuminate\Support\Str;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;

class Seo
{
    public static function make(): Group
    {
        return Group::make([
            'title' => TextInput::make('title')
                ->translateLabel()
                ->label(__('filament-seo::translations.title'))
                ->columnSpan(2),
            'description' => Textarea::make('description')
                ->translateLabel()
                ->label(__('filament-seo::translations.description'))
                ->helperText(function (?string $state): string {
                    return (string) Str::of(strlen($state))
                        ->append(' / ')
                        ->append(160 . ' ')
                        ->append(Str::of(__('filament-seo::translations.characters'))->lower());
                })
                ->reactive()
                ->columnSpan(2)
        ])
            ->afterStateHydrated(function (Group $component, ?Model $record) {
                $component->getChildComponentContainer()->fill(
                    $record?->seo?->only(['title', 'description']) ?: []
                );
            })
            ->statePath('seo')
            ->dehydrated(false)
            ->saveRelationshipsUsing(function (Model $record, array $state) {
                $state = collect($state)
                    ->only([
                        'title',
                        'description'
                    ])
                    ->map(fn ($value) => $value ?: null)
                    ->all();

                if ($record->seo && $record->seo->exists) {
                    $record->seo->update($state);
                } else {
                    $record->seo()->create($state);
                }
            });
    }
}
