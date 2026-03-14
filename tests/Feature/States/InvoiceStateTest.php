<?php

use App\Models\Invoice;
use App\States\Invoice\Draft;
use App\States\Invoice\Issued;
use App\States\Invoice\Overdue;
use App\States\Invoice\Paid;
use App\States\Invoice\PartiallyPaid;
use App\States\Invoice\Voided;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

it('defaults to draft for new invoices', function () {
    $invoice = Invoice::factory()->create();

    expect($invoice->status)->toBeInstanceOf(Draft::class);
});

it('allows valid transitions', function (string $fromClass, string $toClass) {
    $invoice = Invoice::factory()->create();
    $invoice->status = new $fromClass($invoice);
    $invoice->save();

    $invoice->status->transitionTo($toClass);
    $invoice->refresh();

    expect($invoice->status)->toBeInstanceOf($toClass);
})->with([
    'draft -> issued' => [Draft::class, Issued::class],
    'issued -> paid' => [Issued::class, Paid::class],
    'issued -> partially_paid' => [Issued::class, PartiallyPaid::class],
    'issued -> overdue' => [Issued::class, Overdue::class],
    'issued -> voided' => [Issued::class, Voided::class],
    'partially_paid -> paid' => [PartiallyPaid::class, Paid::class],
    'partially_paid -> overdue' => [PartiallyPaid::class, Overdue::class],
    'overdue -> paid' => [Overdue::class, Paid::class],
    'overdue -> partially_paid' => [Overdue::class, PartiallyPaid::class],
]);

it('prevents disallowed transitions', function (string $fromClass, string $toClass) {
    $invoice = Invoice::factory()->create();
    $invoice->status = new $fromClass($invoice);
    $invoice->save();

    $invoice->status->transitionTo($toClass);
})->with([
    'draft -> paid' => [Draft::class, Paid::class],
    'paid -> draft' => [Paid::class, Draft::class],
    'voided -> issued' => [Voided::class, Issued::class],
    'paid -> overdue' => [Paid::class, Overdue::class],
])->throws(CouldNotPerformTransition::class);

it('filters invoices by state using whereState scope', function () {
    Invoice::factory()->create();
    $issued = Invoice::factory()->create();
    $issued->status = new Issued($issued);
    $issued->save();

    $results = Invoice::whereState('status', Issued::class)->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->uuid)->toBe($issued->uuid);
});
