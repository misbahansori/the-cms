<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Taxonomy extends Model
{
    use HasFactory;
    use BelongsToTenant;

    public $timestamps = false;
}
