<?php

namespace App\Observers;

use App\Jobs\GenerateVideoPreviewImage;
use App\Models\Video;
use Illuminate\Support\Str;

class VideoObserver
{
    public function creating(Video $video)
    {
        $video->uuid = Str::uuid();
    }

    public function created(Video $video)
    {
        GenerateVideoPreviewImage::dispatch($video);
    }
}
