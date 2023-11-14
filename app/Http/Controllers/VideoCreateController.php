<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoCreateController extends Controller
{
    public function __invoke()
    {
        return inertia()->render('Videos/Create');
    }
}
