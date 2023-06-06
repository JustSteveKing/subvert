<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Actions\ExtractAudio;
use App\Actions\{GenerateSubtitles, GenerateChapters, GenerateSummary};
use App\Actions\TranslateSubtitles;
use App\Enums\Status;
use App\Models\Process;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Pipeline;

class ProcessVideo implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $timeout = 3600;

    public function __construct(
        public readonly Process $process,
    ) {}

    public function handle(): void
    {
        Pipeline::send(
            passable: $this->process,
        )->through([
            ExtractAudio::class,
            GenerateSubtitles::class,
            TranslateSubtitles::class,
            GenerateChapters::class,
            GenerateSummary::class,
        ])->then(function (Process $process) {
            $process->update([
                'status' => Status::COMPLETE,
            ]);
        });
    }
}
