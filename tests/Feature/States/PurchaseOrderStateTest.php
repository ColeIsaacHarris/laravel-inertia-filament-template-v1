<?php

use App\Models\PurchaseOrder;
use App\States\PurchaseOrder\Cancelled;
use App\States\PurchaseOrder\Closed;
use App\States\PurchaseOrder\Confirmed;
use App\States\PurchaseOrder\Draft;
use App\States\PurchaseOrder\PartiallyReceived;
use App\States\PurchaseOrder\Received;
use App\States\PurchaseOrder\Submitted;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

it('defaults to draft for new purchase orders', function () {
    $po = PurchaseOrder::factory()->create();

    expect($po->status)->toBeInstanceOf(Draft::class);
});

it('allows valid transitions', function (string $fromClass, string $toClass) {
    $po = PurchaseOrder::factory()->create();
    $po->status = new $fromClass($po);
    $po->save();

    $po->status->transitionTo($toClass);
    $po->refresh();

    expect($po->status)->toBeInstanceOf($toClass);
})->with([
    'draft -> submitted' => [Draft::class, Submitted::class],
    'submitted -> confirmed' => [Submitted::class, Confirmed::class],
    'submitted -> cancelled' => [Submitted::class, Cancelled::class],
    'confirmed -> partially_received' => [Confirmed::class, PartiallyReceived::class],
    'confirmed -> cancelled' => [Confirmed::class, Cancelled::class],
    'partially_received -> received' => [PartiallyReceived::class, Received::class],
    'received -> closed' => [Received::class, Closed::class],
]);

it('prevents disallowed transitions', function (string $fromClass, string $toClass) {
    $po = PurchaseOrder::factory()->create();
    $po->status = new $fromClass($po);
    $po->save();

    $po->status->transitionTo($toClass);
})->with([
    'draft -> confirmed' => [Draft::class, Confirmed::class],
    'draft -> cancelled' => [Draft::class, Cancelled::class],
    'received -> draft' => [Received::class, Draft::class],
    'cancelled -> draft' => [Cancelled::class, Draft::class],
])->throws(CouldNotPerformTransition::class);

it('filters purchase orders by state using whereState scope', function () {
    PurchaseOrder::factory()->create();
    $submitted = PurchaseOrder::factory()->create();
    $submitted->status = new Submitted($submitted);
    $submitted->save();

    $results = PurchaseOrder::whereState('status', Submitted::class)->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->uuid)->toBe($submitted->uuid);
});
