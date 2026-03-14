<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HoldRequestSlab extends Model
{
    use HasUuids;

    public $timestamps = false;

    /** @var array<string> */
    protected $fillable = [
    ];

    public function holdRequest(): BelongsTo
    {
        return $this->belongsTo(HoldRequest::class);
    }

    public function slab(): BelongsTo
    {
        return $this->belongsTo(Slab::class);
    }
}
