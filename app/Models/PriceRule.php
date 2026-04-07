<?php

namespace App\Models;

use App\Enums\CustomerTier;
use App\Enums\PricingModel;
use App\Enums\PricingScope;
use Database\Factories\PriceRuleFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceRule extends Model
{
    /** @use HasFactory<PriceRuleFactory> */
    use HasFactory;

    use HasUuids;

    /** @var array<string> */
    protected $fillable = [
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'scope' => PricingScope::class,
            'pricing_model' => PricingModel::class,
            'customer_tier' => CustomerTier::class,
            'effective_from' => 'date',
            'effective_to' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
