<?php

namespace App\Models;

use App\Enums\DeliveryWindow;
use App\States\DeliveryRequest\DeliveryRequestState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStates\HasStates;

class DeliveryRequest extends Model
{
    /** @use HasFactory<\Database\Factories\DeliveryRequestFactory> */
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
            'status' => DeliveryRequestState::class,
            'requested_date' => 'date',
            'requested_window' => DeliveryWindow::class,
            'confirmed_date' => 'date',
            'confirmed_window' => DeliveryWindow::class,
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function deliveryAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'delivery_address_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class, 'order_id');
    }

    public function portalUser(): BelongsTo
    {
        return $this->belongsTo(PortalUser::class);
    }
}
