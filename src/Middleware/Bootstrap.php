<?php

namespace SmallRuralDog\Admin\Middleware;

use Closure;
use SmallRuralDog\Admin\Facades\Admin;
use Illuminate\Http\Request;

class Bootstrap
{
    public function handle(Request $request, Closure $next)
    {
        if (config('admin.https')) \URL::forceScheme('https');
        Admin::bootstrap();

        return $next($request);
    }
}
