<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoUpdateRequest;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoUpdateController extends Controller
{
    public function __invoke(VideoUpdateRequest $request, Video $video)
    {
        $video->update($request->only('title', 'description'));

        return back();
    }
}
