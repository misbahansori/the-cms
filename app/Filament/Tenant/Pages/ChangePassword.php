<?php

namespace App\Filament\Tenant\Pages;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Illuminate\Validation\ValidationException;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Livewire\Notifications;
use Filament\Actions\Concerns\InteractsWithActions;

class ChangePassword extends Page implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.tenant.pages.change-password';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Grid::make()
                    ->columnSpan(1)
                    ->columns(1)
                    ->schema([
                        TextInput::make('current_password')
                            ->label('Current Password')
                            ->password()
                            ->required()
                            ->autocomplete('current-password'),
                        TextInput::make('password')
                            ->label('New Password')
                            ->password()
                            ->confirmed()
                            ->required(),
                        TextInput::make('password_confirmation')
                            ->label('Confirm New Password')
                            ->password()
                            ->required(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save()
    {
        $data = $this->form->getState();
        $user = Auth::user();

        if (!Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'data.current_password' => 'The provided password does not match your current password.',
            ]);
        }

        $user->password = Hash::make($data['password']);

        $user->save();

        $this->form->fill();

        return Notification::make()
            ->title('Your password has been changed.')
            ->success('')
            ->send();
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->action('save'),
            Action::make('cancel')
                ->label('Cancel')
                ->color('gray')
                ->url('/'),
        ];
    }
}
