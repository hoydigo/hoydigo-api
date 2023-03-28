<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Laravel\Passport\Exceptions\MissingScopeException;

class CheckScopes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param mixed ...$scopes
     *
     * @return mixed
     *
     * @throws AuthenticationException
     * @throws MissingScopeException
     */
    public function handle(Request $request, Closure $next, ...$scopes)
    {
        if (! $request->user() || ! $request->user()->token()) {
            return response()->json(['message' => 'Invalid user.'], 403);
        }

        foreach ($scopes as $scope) {
            if (! $request->user()->tokenCan($scope)) {
                return response()->json(['message' => 'Permission denied.'], 403);
            }
        }

        return $next($request);
    }
}
