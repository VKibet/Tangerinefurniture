<?php


use Illuminate\Auth\AuthenticationException;

protected function unauthenticated($request, AuthenticationException $exception)
{
    if ($request->expectsJson()) {
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    }

    return redirect()->guest(route('login'));
}
