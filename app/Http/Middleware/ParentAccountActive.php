<?php

namespace App\Http\Middleware;

use Closure;

class ParentAccountActive
{
    public function handle($request, Closure $next)
    {
        $parent = $request->user('parent-api');

        if (!$parent || !$parent->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Akun orang tua sudah dinonaktifkan'
            ], 403);
        }

        return $next($request);
    }
}