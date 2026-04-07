<?php

namespace App\Models;

use App\Enums\PortalInvitationStatus;
use App\Enums\PortalRole;
use Database\Factories\PortalInvitationFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortalInvitation extends Model
{
    /** @use HasFactory<PortalInvitationFactory> */
    use HasFactory;

    use HasUuids;

    public const UPDATED_AT = null;

    /** @var array<string> */
    protected $fillable = [
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'role' => PortalRole::class,
            'status' => PortalInvitationStatus::class,
            'expires_at' => 'datetime',
            'accepted_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function invitedByPortalUser(): BelongsTo
    {
        return $this->belongsTo(PortalUser::class, 'invited_by_portal_user_id');
    }

    public function invitedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by_user_id');
    }
}
