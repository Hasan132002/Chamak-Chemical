<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPublicLoginEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!SiteSetting::get('public_login_enabled', false)) {
            abort(404);
        }

        return $next($request);
    }
}
