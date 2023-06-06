<?php

declare(strict_types=1);

use App\Http\Controllers\Web\HomeController;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\get;

it('loads the home page', function (): void {
    get(
        uri: action(HomeController::class),
    )->assertSuccessful()->assertInertia(fn (AssertableInertia $page) => $page
        ->component('Home')
        ->etc(),
    );
});
