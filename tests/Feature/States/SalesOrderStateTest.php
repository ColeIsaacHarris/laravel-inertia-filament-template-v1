<?php

use App\Models\SalesOrder;
use App\States\SalesOrder\Cancelled;
use App\States\SalesOrder\Closed;
use App\States\SalesOrder\Confirmed;
use App\States\SalesOrder\Draft;
use App\States\SalesOrder\Invoiced;
use App\States\SalesOrder\PartiallyShipped;
use App\States\SalesOrder\ReadyForFulfillment;
use App\States\SalesOrder\Shipped;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

it('defaults to draft for new sales orders', function () {
    $order = SalesOrder::factory()->create();

    expect($order->status)->toBeInstanceOf(Draft::class);
});

it('allows valid transitions', function (string $fromClass, string $toClass) {
    $order = SalesOrder::factory()->create();
    $order->status = new $fromClass($order);
    $order->save();

    $order->status->transitionTo($toClass);
    $order->refresh();

    expect($order->status)->toBeInstanceOf($toClass);
})->with([
    'draft -> confirmed' => [Draft::class, Confirmed::class],
    'draft -> cancelled' => [Draft::class, Cancelled::class],
    'confirmed -> ready_for_fulfillment' => [Confirmed::class, ReadyForFulfillment::class],
    'confirmed -> cancelled' => [Confirmed::class, Cancelled::class],
    'ready_for_fulfillment -> partially_shipped' => [ReadyForFulfillment::class, PartiallyShipped::class],
    'ready_for_fulfillment -> shipped' => [ReadyForFulfillment::class, Shipped::class],
    'partially_shipped -> shipped' => [PartiallyShipped::class, Shipped::class],
    'shipped -> invoiced' => [Shipped::class, Invoiced::class],
    'invoiced -> closed' => [Invoiced::class, Closed::class],
]);

it('prevents disallowed transitions', function (string $fromClass, string $toClass) {
    $order = SalesOrder::factory()->create();
    $order->status = new $fromClass($order);
    $order->save();

    $order->status->transitionTo($toClass);
})->with([
    'draft -> shipped' => [Draft::class, Shipped::class],
    'confirmed -> shipped' => [Confirmed::class, Shipped::class],
    'shipped -> draft' => [Shipped::class, Draft::class],
    'cancelled -> draft' => [Cancelled::class, Draft::class],
])->throws(CouldNotPerformTransition::class);

it('filters sales orders by state using whereState scope', function () {
    SalesOrder::factory()->create();
    $confirmed = SalesOrder::factory()->create();
    $confirmed->status = new Confirmed($confirmed);
    $confirmed->save();

    $results = SalesOrder::whereState('status', Confirmed::class)->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->uuid)->toBe($confirmed->uuid);
});
