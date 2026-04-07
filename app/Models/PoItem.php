<?php

namespace App\Models;

use Database\Factories\PoItemFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoItem extends Model
{
    /** @use HasFactory<PoItemFactory> */
    use HasFactory;

    use HasUuids;

    const UPDATED_AT = null;

    /** @var array<string> */
    protected $fillable = [
    ];

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
