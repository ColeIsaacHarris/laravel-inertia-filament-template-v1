<?php

namespace App\Models;

use App\Enums\PaymentTerms;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;

    use HasUuids;

    protected $primaryKey = 'uuid';

    /** @var array<string> */
    protected $fillable = [
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'default_payment_terms' => PaymentTerms::class,
            'bank_details_encrypted' => 'encrypted:array',
            'is_active' => 'boolean',
        ];
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function bundles(): HasMany
    {
        return $this->hasMany(Bundle::class);
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function slabs(): HasMany
    {
        return $this->hasMany(Slab::class);
    }

    public function supplierContacts(): HasMany
    {
        return $this->hasMany(SupplierContact::class);
    }

    public function supplierInvoices(): HasMany
    {
        return $this->hasMany(SupplierInvoice::class);
    }
}
