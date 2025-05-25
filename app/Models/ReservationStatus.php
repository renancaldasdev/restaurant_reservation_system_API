<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReservationStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'label',
    ];

    const SLUG_AVAILABLE = 'available';
    const SLUG_PENDING = 'pending';
    const SLUG_CANCELLED = 'cancelled';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'reservation_status_id');
    }

    public static function findBySlugOrFail(string $slug): self
    {
        return self::where('slug', $slug)->firstOrFail();
    }
}
