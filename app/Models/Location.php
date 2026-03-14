<?php

namespace App\Models;

use App\Enums\LocationType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    /** @use HasFactory<\Database\Factories\LocationFactory> */
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
            'location_type' => LocationType::class,
            'bin_configuration' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function containers(): HasMany
    {
        return $this->hasMany(Container::class, 'destination_location_id');
    }

    public function inventoryMovementsFrom(): HasMany
    {
        return $this->hasMany(InventoryMovement::class, 'from_location_id');
    }

    public function inventoryMovementsTo(): HasMany
    {
        return $this->hasMany(InventoryMovement::class, 'to_location_id');
    }

    public function slabs(): HasMany
    {
        return $this->hasMany(Slab::class);
    }
}
