<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PingController extends Controller
{

    public function create()
    {
        return Inertia::render('Pings/Create');
    }

    public function store(Request $request)
    {
        system(env('PING_PATH') . " -c4 $request->url 2>&1", $output);
    }

}
