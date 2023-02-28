<?php

namespace App\Http\Middleware;

// use Auth;
use Closure;
use Illuminate\Http\Request;

class InstallationCheck
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

        if (!file_exists(storage_path('installed')) || !file_exists(base_path('vendor/licensed'))) {
            return redirect('/installation');
        }

        return $next($request);
    }
}
