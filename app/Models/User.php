<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use App\Models\Flag;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasTenants;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Filament\Models\Contracts\FilamentUser;
use Spatie\ModelFlags\Models\Concerns\HasFlags;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasSEO;
    use HasFlags;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'published_at'      => 'datetime',
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return (bool) $this->hasFlag(Flag::ADMIN);
        }

        return true;
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->tenants;
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class);
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->tenants->contains($tenant);
    }
}
