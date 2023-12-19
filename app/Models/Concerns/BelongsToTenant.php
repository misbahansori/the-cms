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
        static::creating(function (Model $model) {
            $tenant = Filament::getTenant();

            $model->tenant_id = $tenant?->id;
        });

        static::addGlobalScope(function ($query) {
            $tenant = Filament::getTenant();

            if ($tenant) {
                $query->where('tenant_id', $tenant->id);
            }
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
