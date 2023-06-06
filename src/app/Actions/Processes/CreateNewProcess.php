<?php

declare(strict_types=1);

namespace App\Actions\Processes;

use App\Http\Payloads\ProcessPayload;
use App\Models\Process;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;

readonly class CreateNewProcess
{
    public function __construct(
        private DatabaseManager $database,
    ) {}

    public function handle(ProcessPayload $payload): Model|Process
    {
        return $this->database->transaction(
            callback: fn () => Process::query()->create([
                'file' => $payload->file->store('videos'),
                'options' => $payload->options,
            ]),
            attempts: 2,
        );
    }
}
