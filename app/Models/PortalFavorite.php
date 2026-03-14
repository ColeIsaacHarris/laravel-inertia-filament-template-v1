<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortalFavorite extends Model
{
    use HasUuids;

    public const UPDATED_AT = null;

    /** @var array<string> */
    protected $fillable = [
    ];

    public function portalUser(): BelongsTo
    {
        return $this->belongsTo(PortalUser::class);
    }

    public function slab(): BelongsTo
    {
        return $this->belongsTo(Slab::class);
    }
}
