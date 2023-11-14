<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoIndexController extends Controller
{
    public function __invoke()
    {
        return inertia()->render('Videos/Index');
    }
}
