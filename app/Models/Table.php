<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'capacity',
        'status_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function status(): BelongsTo
    {
        return $this->belongsTo(TableStatus::class, 'status_id');
    }
}
