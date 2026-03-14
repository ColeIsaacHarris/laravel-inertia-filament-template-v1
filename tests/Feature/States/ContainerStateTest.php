<?php

use App\Models\Container;
use App\States\Container\ArrivedAtPort;
use App\States\Container\Booked;
use App\States\Container\CustomsCleared;
use App\States\Container\CustomsHold;
use App\States\Container\Delivered;
use App\States\Container\InTransit;
use App\States\Container\InTransitDomestic;
use App\States\Container\Loaded;
use App\States\Container\Received;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

it('defaults to booked for new containers', function () {
    $container = Container::factory()->create();

    expect($container->container_status)->toBeInstanceOf(Booked::class);
});

it('allows valid transitions', function (string $fromClass, string $toClass) {
    $container = Container::factory()->create();
    $container->container_status = new $fromClass($container);
    $container->save();

    $container->container_status->transitionTo($toClass);
    $container->refresh();

    expect($container->container_status)->toBeInstanceOf($toClass);
})->with([
    'booked -> loaded' => [Booked::class, Loaded::class],
    'loaded -> in_transit' => [Loaded::class, InTransit::class],
    'in_transit -> arrived_at_port' => [InTransit::class, ArrivedAtPort::class],
    'arrived_at_port -> customs_hold' => [ArrivedAtPort::class, CustomsHold::class],
    'arrived_at_port -> customs_cleared' => [ArrivedAtPort::class, CustomsCleared::class],
    'customs_hold -> customs_cleared' => [CustomsHold::class, CustomsCleared::class],
    'customs_cleared -> in_transit_domestic' => [CustomsCleared::class, InTransitDomestic::class],
    'in_transit_domestic -> delivered' => [InTransitDomestic::class, Delivered::class],
    'delivered -> received' => [Delivered::class, Received::class],
]);

it('prevents disallowed transitions', function (string $fromClass, string $toClass) {
    $container = Container::factory()->create();
    $container->container_status = new $fromClass($container);
    $container->save();

    $container->container_status->transitionTo($toClass);
})->with([
    'booked -> in_transit' => [Booked::class, InTransit::class],
    'loaded -> delivered' => [Loaded::class, Delivered::class],
    'customs_hold -> delivered' => [CustomsHold::class, Delivered::class],
    'received -> booked' => [Received::class, Booked::class],
])->throws(CouldNotPerformTransition::class);

it('filters containers by state using whereState scope', function () {
    Container::factory()->create();
    $loaded = Container::factory()->create();
    $loaded->container_status = new Loaded($loaded);
    $loaded->save();

    $results = Container::whereState('container_status', Loaded::class)->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->id)->toBe($loaded->id);
});
