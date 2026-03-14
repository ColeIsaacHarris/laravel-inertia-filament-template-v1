<?php

namespace App\Models;

use App\Enums\DepositStatus;
use App\Enums\HoldType;
use App\States\Hold\HoldState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ModelStates\HasStates;

class Hold extends Model
{
    /** @use HasFactory<\Database\Factories\HoldFactory> */
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
            'hold_type' => HoldType::class,
            'status' => HoldState::class,
            'expiry_date' => 'date',
            'deposit_status' => DepositStatus::class,
            'reminder_sent' => 'boolean',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function slabs(): BelongsToMany
    {
        return $this->belongsToMany(Slab::class, 'hold_slabs');
    }

    public function salesOrders(): HasMany
    {
        return $this->hasMany(SalesOrder::class);
    }

    public function holdRequests(): HasMany
    {
        return $this->hasMany(HoldRequest::class);
    }
}
