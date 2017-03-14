<?php

namespace Modules\Admin\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($user = Sentinel::getUser()) {
            if($user->inRole('superadmin')) {
                return $next($request);
            }

            if (!$user->hasAccess('admin.browse')) {
                return redirect()->route('admin.login');
            }
        } else {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}