<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use \Awcodes\Curator\Models\Media as CuratorMedia;

class Media extends CuratorMedia
{
    use BelongsToTenant;
}
