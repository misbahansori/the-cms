<?php

namespace App\Filament\Tenant\Resources\TagResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Tenant\Resources\TagResource;

class CreateTag extends CreateRecord
{
    protected static string $resource = TagResource::class;
}
