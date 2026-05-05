<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class HealthController extends Controller
{
    public function show(): Response
    {
        return response('ok', 200);
    }
}
