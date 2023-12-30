<?php

namespace App\Providers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Media;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Category;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::unguard();

        Relation::enforceMorphMap([
            'post'      => Post::class,
            'category' => Category::class,
            'tag'       => Tag::class,
            'media'     => Media::class,
        ]);

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

        Page::$reportValidationErrorUsing = function (ValidationException $exception) {
            Notification::make()
                ->title($exception->getMessage())
                ->danger()
                ->send();
        };
    }
}
