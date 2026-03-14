<?php

use App\Models\Slab;
use App\States\Slab\Available;
use App\States\Slab\Consigned;
use App\States\Slab\CutConsumed;
use App\States\Slab\Damaged;
use App\States\Slab\InTransit;
use App\States\Slab\OnHold;
use App\States\Slab\Reserved;
use App\States\Slab\Returned;
use App\States\Slab\Sold;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

it('defaults to in_transit for new slabs', function () {
    $slab = Slab::factory()->create();

    expect($slab->status)->toBeInstanceOf(InTransit::class);
});

it('allows valid transitions', function (string $fromClass, string $toClass) {
    $slab = Slab::factory()->create();
    $slab->status = new $fromClass($slab);
    $slab->save();

    $slab->status->transitionTo($toClass);
    $slab->refresh();

    expect($slab->status)->toBeInstanceOf($toClass);
})->with([
    'in_transit -> available' => [InTransit::class, Available::class],
    'available -> on_hold' => [Available::class, OnHold::class],
    'available -> reserved' => [Available::class, Reserved::class],
    'available -> consigned' => [Available::class, Consigned::class],
    'available -> damaged' => [Available::class, Damaged::class],
    'on_hold -> available' => [OnHold::class, Available::class],
    'on_hold -> reserved' => [OnHold::class, Reserved::class],
    'reserved -> sold' => [Reserved::class, Sold::class],
    'reserved -> available' => [Reserved::class, Available::class],
    'sold -> cut_consumed' => [Sold::class, CutConsumed::class],
    'sold -> returned' => [Sold::class, Returned::class],
    'returned -> available' => [Returned::class, Available::class],
    'returned -> damaged' => [Returned::class, Damaged::class],
    'consigned -> available' => [Consigned::class, Available::class],
    'consigned -> sold' => [Consigned::class, Sold::class],
    'damaged -> available' => [Damaged::class, Available::class],
]);

it('prevents disallowed transitions', function (string $fromClass, string $toClass) {
    $slab = Slab::factory()->create();
    $slab->status = new $fromClass($slab);
    $slab->save();

    $slab->status->transitionTo($toClass);
})->with([
    'in_transit -> sold' => [InTransit::class, Sold::class],
    'available -> sold' => [Available::class, Sold::class],
    'sold -> available' => [Sold::class, Available::class],
    'damaged -> sold' => [Damaged::class, Sold::class],
    'reserved -> damaged' => [Reserved::class, Damaged::class],
])->throws(CouldNotPerformTransition::class);

it('filters slabs by state using whereState scope', function () {
    Slab::factory()->create();
    $available = Slab::factory()->create();
    $available->status = new Available($available);
    $available->save();

    $results = Slab::whereState('status', Available::class)->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->id)->toBe($available->id);
});
