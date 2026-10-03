<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApplicationSuspended
{
public function handle(Request $request, Closure $next): Response
{
    if (config('app.suspended')) {
        return response()->view('account-suspended', [], 503);
    }

    return $next($request);
}
}