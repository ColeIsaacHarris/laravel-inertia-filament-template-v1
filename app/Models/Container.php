<?php

namespace App\Models;

use App\Enums\ContainerSize;
use App\Enums\CustomsStatus;
use App\States\Container\ContainerState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ModelStates\HasStates;

class Container extends Model
{
    /** @use HasFactory<\Database\Factories\ContainerFactory> */
    use HasFactory;

    use HasStates;
    use HasUuids;

    protected $primaryKey = 'uuid';

    /** @var array<string> */
    protected $fillable = [
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'container_size' => ContainerSize::class,
            'container_status' => ContainerState::class,
            'customs_status' => CustomsStatus::class,
            'etd' => 'date',
            'eta' => 'date',
            'actual_arrival_date' => 'date',
            'delivery_date' => 'date',
        ];
    }

    public function destinationLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'destination_location_id');
    }

    public function slabs(): HasMany
    {
        return $this->hasMany(Slab::class);
    }

    public function containerCosts(): HasMany
    {
        return $this->hasMany(ContainerCost::class);
    }

    public function purchaseOrders(): BelongsToMany
    {
        return $this->belongsToMany(PurchaseOrder::class, 'container_purchase_orders', 'container_id', 'purchase_order_id');
    }
}
