<?php

namespace App\Filament\Tenant\Resources\AuthorResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Tenant\Resources\AuthorResource;

class CreateAuthor extends CreateRecord
{
    protected static string $resource = AuthorResource::class;
}
