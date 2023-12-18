<?php

namespace App\Providers;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::unguard();

        TextInput::macro('slug', function (string $source) {
            return $this->unique(
                modifyRuleUsing: fn (Unique $rule) => $rule->where('tenant_id', Filament::getTenant()->id),
                ignoreRecord: true
            )
                ->suffixAction(
                    fn (): Action  =>  Action::make('generate_slug')
                        ->icon('heroicon-o-arrow-path')
                        ->tooltip('Generate Slug')
                        ->color('success')
                        ->action(
                            fn (Get $get, Set $set) => $set('slug', Str::slug($get($source)))
                        ),
                )
                ->alphaDash();
        });
    }
}
