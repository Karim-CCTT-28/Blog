<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
           $admin_id = $request->session()->get("admin_id");
        
        if (!$admin_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}