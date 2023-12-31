<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: int implements HasLabel, HasColor
{
    case Draft = 1;
    case ReadyForReview = 2;
    case Reviewing = 3;
    case ReviewCompleted = 4;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::ReadyForReview => 'Ready for Review',
            self::Reviewing => 'Reviewing',
            self::ReviewCompleted => 'Review Completed',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::ReadyForReview => 'info',
            self::Reviewing => 'yellow',
            self::ReviewCompleted => 'green',
        };
    }
}
