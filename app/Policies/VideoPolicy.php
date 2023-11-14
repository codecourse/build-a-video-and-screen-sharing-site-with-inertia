<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;

class VideoPolicy
{
    public function show(User $user, Video $video)
    {
        return $user->id === $video->user_id;
    }

    public function update(User $user, Video $video)
    {
        return $user->id === $video->user_id;
    }
}
