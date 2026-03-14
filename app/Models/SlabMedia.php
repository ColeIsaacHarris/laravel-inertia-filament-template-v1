<?php

namespace App\Models;

use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SlabMedia extends Model
{
    /** @use HasFactory<\Database\Factories\SlabMediaFactory> */
    use HasFactory;

    use HasUuids;

    protected $primaryKey = 'uuid';

    public const UPDATED_AT = null;

    /** @var array<string> */
    protected $fillable = [
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'media_type' => MediaType::class,
            'is_primary' => 'boolean',
        ];
    }

    public function slab(): BelongsTo
    {
        return $this->belongsTo(Slab::class);
    }
}
