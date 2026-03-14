<?php

namespace App\Models;

use App\Enums\HoldType;
use App\States\HoldRequest\HoldRequestState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\ModelStates\HasStates;

class HoldRequest extends Model
{
    /** @use HasFactory<\Database\Factories\HoldRequestFactory> */
    use HasFactory;

    use HasStates;
    use HasUuids;

    protected $primaryKey = 'uuid';

    public const UPDATED_AT = null;

    /** @var array<string> */
    protected $fillable = [
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'status' => HoldRequestState::class,
            'requested_hold_type' => HoldType::class,
            'reviewed_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function hold(): BelongsTo
    {
        return $this->belongsTo(Hold::class);
    }

    public function portalUser(): BelongsTo
    {
        return $this->belongsTo(PortalUser::class);
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function slabs(): BelongsToMany
    {
        return $this->belongsToMany(Slab::class, 'hold_request_slabs', 'hold_request_id', 'slab_id');
    }
}
