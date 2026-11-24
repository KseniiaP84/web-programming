<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPlaceOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        $ownerId = $request->header('X-Place-Owner-ID');

        if (! $ownerId || ! ctype_digit($ownerId)) {
            return response()->json([
                'status' => 'access_denied',
                'message' => 'Доступ заборонено. Не вказано ідентифікатор власника закладу.',
            ], 403);
        }

        $response = $next($request);

        $response->headers->set(
            'X-Security-Policy',
            'Owner-Verified'
        );

        return $response;
    }
}
