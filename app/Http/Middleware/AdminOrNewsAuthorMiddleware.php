<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOrNewsAuthorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $newsId = $request->route('news')->user_id;
        $userNewRole=auth()->user() ? auth()->user()->role : null;
        if ($userNewRole === 'admin' || ($userNewRole && $userNewRole->id === $newsId->user_id)) {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');
    }
}
