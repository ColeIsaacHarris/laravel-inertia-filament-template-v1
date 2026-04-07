<?php

namespace App\Models;

use App\Enums\ContainerSize;
use App\Enums\PaymentTerms;
use App\States\PurchaseOrder\PurchaseOrderState;
use Database\Factories\PurchaseOrderFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ModelStates\HasStates;

class PurchaseOrder extends Model
{
    /** @use HasFactory<PurchaseOrderFactory> */
    use HasFactory;

    use HasStates;
    use HasUuids;

    /** @var array<string> */
    protected $fillable = [
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'status' => PurchaseOrderState::class,
            'payment_terms' => PaymentTerms::class,
            'expected_container_size' => ContainerSize::class,
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function poItems(): HasMany
    {
        return $this->hasMany(PoItem::class);
    }

    public function poDocuments(): HasMany
    {
        return $this->hasMany(PoDocument::class);
    }

    public function containers(): BelongsToMany
    {
        return $this->belongsToMany(Container::class, 'container_purchase_orders', 'purchase_order_id', 'container_id');
    }

    public function supplierInvoices(): HasMany
    {
        return $this->hasMany(SupplierInvoice::class);
    }
}
