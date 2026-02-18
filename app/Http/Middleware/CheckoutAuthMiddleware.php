<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckoutAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $requireLogin = SiteSetting::get('require_login_for_checkout', false);

        if ($requireLogin && !auth()->check()) {
            return redirect()->route('login')
                ->with('error', __('Please login to proceed with checkout'));
        }

        return $next($request);
    }
}
