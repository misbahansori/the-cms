<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\ModelFlags\Models\Flag as SpatieFlag;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flag extends SpatieFlag
{
    use HasFactory;

    const ADMIN = 'admin';
}
