<?php

declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function formatToBrazilian(string|\DateTimeInterface|null $date): ?string
    {
        if (!$date) {
            return null;
        }

        return Carbon::parse($date)->format('d/m/Y H:i');
    }
}
