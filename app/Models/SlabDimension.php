<?php

namespace App\Models;

use App\Enums\DimensionStage;
use Database\Factories\SlabDimensionFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SlabDimension extends Model
{
    /** @use HasFactory<SlabDimensionFactory> */
    use HasFactory;

    use HasUuids;

    public $timestamps = false;

    /** @var array<string> */
    protected $fillable = [
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'stage' => DimensionStage::class,
            'measured_at' => 'datetime',
        ];
    }

    public function slab(): BelongsTo
    {
        return $this->belongsTo(Slab::class);
    }

    public function measuredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'measured_by');
    }
}
