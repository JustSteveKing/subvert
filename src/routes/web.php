<?php

declare(strict_types=1);

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProcessController;
use App\Http\Controllers\Web\ViewProcessedFileController;
use Illuminate\Support\Facades\Route;
use App\Models\Process;

Route::get('/', HomeController::class)->name('home');
Route::post('process', ProcessController::class)->name('process');
Route::get('process/{uuid}', ViewProcessedFileController::class)->name('subvert:view');

Route::get('/process/{process}/download', function (Process $process) {
    $filename = "subtitles-{$process->id}.vtt";

    return response($process->transcript, 200, [
        'Content-Type' => 'text/vtt',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ]);
});
