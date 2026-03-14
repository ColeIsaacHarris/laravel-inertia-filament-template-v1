<?php

namespace App\Models;

use App\Enums\ContactRole;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    /** @use HasFactory<\Database\Factories\ContactFactory> */
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
            'role' => ContactRole::class,
            'is_portal_eligible' => 'boolean',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerInteractions(): HasMany
    {
        return $this->hasMany(CustomerInteraction::class);
    }

    public function portalUsers(): HasMany
    {
        return $this->hasMany(PortalUser::class);
    }
}
