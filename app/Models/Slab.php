<?php

namespace App\Models;

use App\Enums\QualityGrade;
use App\Enums\SlabFinish;
use App\States\Slab\SlabState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ModelStates\HasStates;

class Slab extends Model
{
    /** @use HasFactory<\Database\Factories\SlabFactory> */
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
            'status' => SlabState::class,
            'finish' => SlabFinish::class,
            'quality_grade' => QualityGrade::class,
            'portal_visible' => 'boolean',
        ];
    }

    public function bundle(): BelongsTo
    {
        return $this->belongsTo(Bundle::class);
    }

    public function consignmentLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'consignment_location_id');
    }

    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class);
    }

    public function dimensions(): HasMany
    {
        return $this->hasMany(SlabDimension::class);
    }

    public function holds(): BelongsToMany
    {
        return $this->belongsToMany(Hold::class, 'hold_slabs', 'slab_id', 'hold_id');
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(SlabMedia::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
