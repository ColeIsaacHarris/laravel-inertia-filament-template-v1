<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CycleCountItem extends Model
{
    /** @use HasFactory<\Database\Factories\CycleCountItemFactory> */
    use HasFactory;

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
            'is_discrepancy' => 'boolean',
        ];
    }

    public function actualLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'actual_location_id');
    }

    public function adjustmentApprovedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adjustment_approved_by');
    }

    public function cycleCount(): BelongsTo
    {
        return $this->belongsTo(CycleCount::class);
    }

    public function expectedLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'expected_location_id');
    }

    public function slab(): BelongsTo
    {
        return $this->belongsTo(Slab::class);
    }
}
