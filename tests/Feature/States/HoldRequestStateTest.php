<?php

use App\Models\HoldRequest;
use App\States\HoldRequest\Approved;
use App\States\HoldRequest\Declined;
use App\States\HoldRequest\Expired;
use App\States\HoldRequest\PendingReview;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

it('defaults to pending_review for new hold requests', function () {
    $request = HoldRequest::factory()->create();

    expect($request->status)->toBeInstanceOf(PendingReview::class);
});

it('allows valid transitions', function (string $fromClass, string $toClass) {
    $request = HoldRequest::factory()->create();
    $request->status = new $fromClass($request);
    $request->save();

    $request->status->transitionTo($toClass);
    $request->refresh();

    expect($request->status)->toBeInstanceOf($toClass);
})->with([
    'pending_review -> approved' => [PendingReview::class, Approved::class],
    'pending_review -> declined' => [PendingReview::class, Declined::class],
    'pending_review -> expired' => [PendingReview::class, Expired::class],
]);

it('prevents disallowed transitions', function (string $fromClass, string $toClass) {
    $request = HoldRequest::factory()->create();
    $request->status = new $fromClass($request);
    $request->save();

    $request->status->transitionTo($toClass);
})->with([
    'approved -> pending_review' => [Approved::class, PendingReview::class],
    'declined -> approved' => [Declined::class, Approved::class],
    'expired -> pending_review' => [Expired::class, PendingReview::class],
])->throws(CouldNotPerformTransition::class);

it('filters hold requests by state using whereState scope', function () {
    HoldRequest::factory()->create();
    $approved = HoldRequest::factory()->create();
    $approved->status = new Approved($approved);
    $approved->save();

    $results = HoldRequest::whereState('status', Approved::class)->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->uuid)->toBe($approved->uuid);
});
