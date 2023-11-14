<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoViewController extends Controller
{
    public function __invoke(Video $video)
    {
        return inertia()->render('Videos/View', [
            'video' => VideoResource::make($video)
        ]);
    }
}
