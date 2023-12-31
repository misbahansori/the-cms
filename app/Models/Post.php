<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;
    use BelongsToTenant;
    use HasSEO;

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_SCHEDULED = 'scheduled';

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id', 'id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tag_post');
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'author_post', 'post_id', 'author_id');
    }

    protected function publishStatus(): Attribute
    {
        return Attribute::make(function () {
            if ($this->published_at && $this->published_at->isFuture()) {
                return Post::STATUS_SCHEDULED;
            }

            if ($this->published_at) {
                return Post::STATUS_PUBLISHED;
            }

            return Post::STATUS_DRAFT;
        });
    }
}
