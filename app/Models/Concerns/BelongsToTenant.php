<?php

namespace App\Models\Concerns;

use App\Models\Tenant;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        $tenant = Filament::getTenant() ?: null;

        if (!$tenant || !($tenant instanceof Tenant)) {
            return;
        }

        static::creating(function (Model $model) use ($tenant) {
            $model->tenant_id = $tenant->id;
        });

        static::addGlobalScope(
            fn ($query) => $query->whereBelongsTo($tenant)
        );
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
