<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Blocked {

    public function handle($request, Closure $next) {
        if (!Auth::check()) {
            return $next($request);
        }

        if (Auth::user()->isBlocked()) {
            return redirect('/logout');
        }
        else {
            return $next($request);
        }

        return redirect('/');
    }
}
