<?php

use App\Models\Quote;
use App\States\Quote\Accepted;
use App\States\Quote\Declined;
use App\States\Quote\Draft;
use App\States\Quote\Expired;
use App\States\Quote\Revised;
use App\States\Quote\Sent;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

it('defaults to draft for new quotes', function () {
    $quote = Quote::factory()->create();

    expect($quote->status)->toBeInstanceOf(Draft::class);
});

it('allows valid transitions', function (string $fromClass, string $toClass) {
    $quote = Quote::factory()->create();
    $quote->status = new $fromClass($quote);
    $quote->save();

    $quote->status->transitionTo($toClass);
    $quote->refresh();

    expect($quote->status)->toBeInstanceOf($toClass);
})->with([
    'draft -> sent' => [Draft::class, Sent::class],
    'sent -> accepted' => [Sent::class, Accepted::class],
    'sent -> declined' => [Sent::class, Declined::class],
    'sent -> expired' => [Sent::class, Expired::class],
    'sent -> revised' => [Sent::class, Revised::class],
]);

it('prevents disallowed transitions', function (string $fromClass, string $toClass) {
    $quote = Quote::factory()->create();
    $quote->status = new $fromClass($quote);
    $quote->save();

    $quote->status->transitionTo($toClass);
})->with([
    'draft -> accepted' => [Draft::class, Accepted::class],
    'accepted -> draft' => [Accepted::class, Draft::class],
    'declined -> sent' => [Declined::class, Sent::class],
    'expired -> draft' => [Expired::class, Draft::class],
])->throws(CouldNotPerformTransition::class);

it('filters quotes by state using whereState scope', function () {
    Quote::factory()->create();
    $sent = Quote::factory()->create();
    $sent->status = new Sent($sent);
    $sent->save();

    $results = Quote::whereState('status', Sent::class)->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->uuid)->toBe($sent->uuid);
});
