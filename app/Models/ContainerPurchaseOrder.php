<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContainerPurchaseOrder extends Model
{
    use HasUuids;

    const UPDATED_AT = null;

    /** @var array<string> */
    protected $fillable = [
    ];

    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class);
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
