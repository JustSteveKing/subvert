<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Models\Process;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ViewProcessedFileController
{
    public function __invoke(Request $request, string $uuid): Response
    {
        $process = Process::query()->findOrFail(
            id: $uuid,
        );

        return Inertia::render(
            component: 'Process',
            props: [
                'process' => $process,
            ]
        );
    }
}
