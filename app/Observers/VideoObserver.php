<?php

namespace App\Observers;

use App\Models\Video;
use Illuminate\Support\Str;

class VideoObserver
{
    public function creating(Video $video)
    {
        $video->uuid = Str::uuid();
    }
}
