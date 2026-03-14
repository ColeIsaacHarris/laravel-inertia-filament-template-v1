<?php

namespace App\Models;

use App\Enums\CostAllocationMethod;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContainerCost extends Model
{
    /** @use HasFactory<\Database\Factories\ContainerCostFactory> */
    use HasFactory;

    use HasUuids;

    const UPDATED_AT = null;

    protected $primaryKey = 'uuid';

    /** @var array<string> */
    protected $fillable = [
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'allocation_method' => CostAllocationMethod::class,
        ];
    }

    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class);
    }
}
