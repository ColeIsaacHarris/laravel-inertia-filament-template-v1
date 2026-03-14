<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FabricatorSlabPricing extends Model
{
    /** @use HasFactory<\Database\Factories\FabricatorSlabPricingFactory> */
    use HasFactory;

    use HasUuids;

    protected $primaryKey = 'uuid';

    /** @var array<string> */
    protected $fillable = [
    ];

    public function fabricator(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'fabricator_id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function slab(): BelongsTo
    {
        return $this->belongsTo(Slab::class);
    }
}
