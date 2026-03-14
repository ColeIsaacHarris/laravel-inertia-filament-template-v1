<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditMemo extends Model
{
    /** @use HasFactory<\Database\Factories\CreditMemoFactory> */
    use HasFactory;

    use HasUuids;

    const UPDATED_AT = null;

    protected $primaryKey = 'uuid';

    /** @var array<string> */
    protected $fillable = [
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
