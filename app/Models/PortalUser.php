<?php

namespace App\Models;

use App\Enums\PortalRole;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PortalUser extends Model
{
    /** @use HasFactory<\Database\Factories\PortalUserFactory> */
    use HasFactory;

    use HasUuids;

    /** @var array<string> */
    protected $fillable = [
    ];

    /** @var list<string> */
    protected $hidden = [
        'password_hash',
        'two_factor_secret',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'role' => PortalRole::class,
            'permissions' => 'array',
            'two_factor_enabled' => 'boolean',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function deliveryRequests(): HasMany
    {
        return $this->hasMany(DeliveryRequest::class);
    }

    public function fabricator(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'fabricator_id');
    }

    public function holdRequests(): HasMany
    {
        return $this->hasMany(HoldRequest::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_portal_user_id');
    }

    public function portalFavorites(): HasMany
    {
        return $this->hasMany(PortalFavorite::class);
    }

    public function portalInvitations(): HasMany
    {
        return $this->hasMany(PortalInvitation::class, 'invited_by_portal_user_id');
    }
}
