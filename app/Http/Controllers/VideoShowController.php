<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoShowRequest;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoShowController extends Controller
{
    public function __invoke(VideoShowRequest $request, Video $video)
    {
        return inertia()->render('Videos/Show', [
            'video' => VideoResource::make($video)
        ]);
    }
}
