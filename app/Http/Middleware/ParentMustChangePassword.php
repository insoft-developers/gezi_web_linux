<?php

namespace App\Http\Middleware;

use Closure;

class ParentMustChangePassword
{
    public function handle($request, Closure $next)
    {
        $parent = $request->user('parent-api');

        if ($parent && $parent->must_change_password) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan ganti password terlebih dahulu',
                'must_change_password' => true,
            ], 403);
        }

        return $next($request);
    }
}