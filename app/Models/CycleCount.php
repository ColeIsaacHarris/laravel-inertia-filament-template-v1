<?php

namespace App\Models;

use Database\Factories\CycleCountFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CycleCount extends Model
{
    /** @use HasFactory<CycleCountFactory> */
    use HasFactory;

    use HasUuids;

    public const UPDATED_AT = null;

    /** @var array<string> */
    protected $fillable = [
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }

    public function cycleCountItems(): HasMany
    {
        return $this->hasMany(CycleCountItem::class);
    }

    public function initiatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
