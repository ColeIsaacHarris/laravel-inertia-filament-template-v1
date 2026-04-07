<?php

namespace App\Models;

use Database\Factories\BundleFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bundle extends Model
{
    /** @use HasFactory<BundleFactory> */
    use HasFactory;

    use HasUuids;

    /** @var array<string> */
    protected $fillable = [
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function slabs(): HasMany
    {
        return $this->hasMany(Slab::class);
    }
}
