<?php

declare(strict_types=1);

namespace App\Services\Queue;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\PendingDispatch;

class DispatchableBus
{
    public function dispatch(ShouldQueue $job): PendingDispatch
    {
        return new PendingDispatch(
            job: $job,
        );
    }
}
