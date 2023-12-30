<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\UserResource;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('save')
                ->action('save'),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        return $data;
    }
}
