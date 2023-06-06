<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Home');
    }
}
