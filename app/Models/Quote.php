<?php

namespace App\Models;

use App\Enums\PaymentTerms;
use App\States\Quote\QuoteState;
use Database\Factories\QuoteFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ModelStates\HasStates;

class Quote extends Model
{
    /** @use HasFactory<QuoteFactory> */
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
            'status' => QuoteState::class,
            'expiry_date' => 'date',
            'payment_terms' => PaymentTerms::class,
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function salesRep(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sales_rep_id');
    }

    public function previousVersion(): BelongsTo
    {
        return $this->belongsTo(Quote::class, 'previous_version_id');
    }

    public function quoteItems(): HasMany
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(Quote::class, 'previous_version_id');
    }

    public function salesOrders(): HasMany
    {
        return $this->hasMany(SalesOrder::class);
    }
}
