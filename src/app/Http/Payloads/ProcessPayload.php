<?php

declare(strict_types=1);

namespace App\Http\Payloads;

use Illuminate\Http\UploadedFile;

readonly class ProcessPayload
{
    public function __construct(
        public UploadedFile $file,
        public array $options,
    ) {}
}
