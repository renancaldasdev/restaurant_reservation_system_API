<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TableStatus extends Model
{
    protected $table = 'table_statuses';
    protected $fillable = [
        'slug',
        'label',
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    const SLUG_RESERVED = 'reserved';
    const SLUG_AVAILABLE = 'available';
    const SLUG_PENDING = 'pending';
    const SLUG_CANCELLED = 'cancelled';

    public function tables(): HasMany
    {
        return $this->hasMany(Table::class, 'status_id');
    }

    public static function findBySlugOrFail(string $slug): self
    {
        return self::where('slug', $slug)->firstOrFail();
    }

}
