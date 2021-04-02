<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfInsecure
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if not local environment AND the request isn't safe
        if (!app()->isLocal() && !$request->secure()) {
            // redirect to the mathching secure url
            return redirect()->secure($request->path());
        }

        return $next($request);
    }
}
