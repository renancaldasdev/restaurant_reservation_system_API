<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccessHelper
{
    public static function denyIfNotAdmin(Request $request, $message): ?JsonResponse
    {
        if (!$request->user()->hasRole('admin')) {
            return response()->json([
                'message' => $message,
            ], 403);
        }

        return null;
    }
}
