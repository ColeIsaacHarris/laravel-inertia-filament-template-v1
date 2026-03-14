<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortalNotification extends Model
{
    /** @use HasFactory<\Database\Factories\PortalNotificationFactory> */
    use HasFactory;

    use HasUuids;

    protected $table = 'notifications';

    protected $primaryKey = 'uuid';

    public const UPDATED_AT = null;

    /** @var array<string> */
    protected $fillable = [
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
            'email_sent' => 'boolean',
            'email_sent_at' => 'datetime',
        ];
    }

    public function recipientPortalUser(): BelongsTo
    {
        return $this->belongsTo(PortalUser::class, 'recipient_portal_user_id');
    }

    public function recipientUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }
}
