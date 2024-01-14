<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
use App\Models\Concerns\HasFeaturedImage;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasFactory;
    use BelongsToTenant;
    use HasRecursiveRelationships;
    use HasSEO;
    use HasFeaturedImage;

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
