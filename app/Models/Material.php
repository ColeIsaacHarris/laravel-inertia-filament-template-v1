<?php

namespace App\Models;

use App\Enums\ColorFamily;
use App\Enums\MaterialType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
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
            'material_type' => MaterialType::class,
            'color_family' => ColorFamily::class,
        ];
    }

    public function bundles(): HasMany
    {
        return $this->hasMany(Bundle::class);
    }

    public function priceRules(): HasMany
    {
        return $this->hasMany(PriceRule::class);
    }

    public function slabs(): HasMany
    {
        return $this->hasMany(Slab::class);
    }
}
