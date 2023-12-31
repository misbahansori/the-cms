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
        $tenant = Filament::getTenant() ?: request('tenant') ?: null;

        if (!$tenant || !($tenant instanceof Tenant)) {
            return;
        }

        static::creating(function (Model $model) use ($tenant) {
            $model->tenant_id = $tenant->id;
        });

        static::addGlobalScope(function ($query) use ($tenant) {
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
