<?php

use App\Models\DeliveryRequest;
use App\States\DeliveryRequest\AlternativeProposed;
use App\States\DeliveryRequest\Cancelled;
use App\States\DeliveryRequest\Completed;
use App\States\DeliveryRequest\Confirmed;
use App\States\DeliveryRequest\Declined;
use App\States\DeliveryRequest\Requested;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

it('defaults to requested for new delivery requests', function () {
    $request = DeliveryRequest::factory()->create();

    expect($request->status)->toBeInstanceOf(Requested::class);
});

it('allows valid transitions', function (string $fromClass, string $toClass) {
    $request = DeliveryRequest::factory()->create();
    $request->status = new $fromClass($request);
    $request->save();

    $request->status->transitionTo($toClass);
    $request->refresh();

    expect($request->status)->toBeInstanceOf($toClass);
})->with([
    'requested -> confirmed' => [Requested::class, Confirmed::class],
    'requested -> alternative_proposed' => [Requested::class, AlternativeProposed::class],
    'requested -> declined' => [Requested::class, Declined::class],
    'alternative_proposed -> confirmed' => [AlternativeProposed::class, Confirmed::class],
    'alternative_proposed -> declined' => [AlternativeProposed::class, Declined::class],
    'confirmed -> completed' => [Confirmed::class, Completed::class],
    'confirmed -> cancelled' => [Confirmed::class, Cancelled::class],
]);

it('prevents disallowed transitions', function (string $fromClass, string $toClass) {
    $request = DeliveryRequest::factory()->create();
    $request->status = new $fromClass($request);
    $request->save();

    $request->status->transitionTo($toClass);
})->with([
    'requested -> completed' => [Requested::class, Completed::class],
    'declined -> confirmed' => [Declined::class, Confirmed::class],
    'completed -> requested' => [Completed::class, Requested::class],
    'cancelled -> confirmed' => [Cancelled::class, Confirmed::class],
])->throws(CouldNotPerformTransition::class);

it('filters delivery requests by state using whereState scope', function () {
    DeliveryRequest::factory()->create();
    $confirmed = DeliveryRequest::factory()->create();
    $confirmed->status = new Confirmed($confirmed);
    $confirmed->save();

    $results = DeliveryRequest::whereState('status', Confirmed::class)->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->id)->toBe($confirmed->id);
});
