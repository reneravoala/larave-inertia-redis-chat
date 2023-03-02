<?php

namespace App\Http\Controllers;

use Cmgmyr\Messenger\Models\Thread;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Dashboard', [
            'threads' => Thread::getAllLatest()->get(),
        ]);
    }
}
