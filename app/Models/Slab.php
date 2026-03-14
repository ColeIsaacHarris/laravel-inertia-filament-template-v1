<?php

namespace App\Models;

use App\States\Slab\SlabState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

class Slab extends Model
{
    /** @use HasFactory<\Database\Factories\SlabFactory> */
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
            'status' => SlabState::class,
        ];
    }
}
