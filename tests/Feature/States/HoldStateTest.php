<?php

use App\Models\Hold;
use App\States\Hold\Active;
use App\States\Hold\Converted;
use App\States\Hold\Expired;
use App\States\Hold\Released;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

it('defaults to active for new holds', function () {
    $hold = Hold::factory()->create();

    expect($hold->status)->toBeInstanceOf(Active::class);
});

it('allows valid transitions', function (string $fromClass, string $toClass) {
    $hold = Hold::factory()->create();
    $hold->status = new $fromClass($hold);
    $hold->save();

    $hold->status->transitionTo($toClass);
    $hold->refresh();

    expect($hold->status)->toBeInstanceOf($toClass);
})->with([
    'active -> expired' => [Active::class, Expired::class],
    'active -> converted' => [Active::class, Converted::class],
    'active -> released' => [Active::class, Released::class],
]);

it('prevents disallowed transitions', function (string $fromClass, string $toClass) {
    $hold = Hold::factory()->create();
    $hold->status = new $fromClass($hold);
    $hold->save();

    $hold->status->transitionTo($toClass);
})->with([
    'expired -> active' => [Expired::class, Active::class],
    'converted -> active' => [Converted::class, Active::class],
    'released -> active' => [Released::class, Active::class],
    'expired -> converted' => [Expired::class, Converted::class],
])->throws(CouldNotPerformTransition::class);

it('filters holds by state using whereState scope', function () {
    Hold::factory()->create();
    $expired = Hold::factory()->create();
    $expired->status = new Expired($expired);
    $expired->save();

    $results = Hold::whereState('status', Expired::class)->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->id)->toBe($expired->id);
});
