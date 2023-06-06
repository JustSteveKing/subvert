<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Actions\Processes\CreateNewProcess;
use App\Http\Requests\Web\ProcessRequest;
use App\Jobs\ProcessVideo;
use App\Services\Queue\DispatchableBus;
use Illuminate\Http\RedirectResponse;

readonly class ProcessController
{
    public function __construct(
        private CreateNewProcess $action,
        private DispatchableBus $bus,
    ) {}

    public function __invoke(ProcessRequest $request): RedirectResponse
    {
        $process = $this->action->handle(
            payload: $request->payload(),
        );

        $this->bus->dispatch(
            job: new ProcessVideo(
                process: $process,
            ),
        );

        return new RedirectResponse(
            url: route('subvert:view', $process->getKey()),
        );
    }
}
