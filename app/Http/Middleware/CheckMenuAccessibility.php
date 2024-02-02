<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMenuAccessibility
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // get menu from request
        $menu = $request->menu;

        // check if menu is public and status login
        if ($menu && (!$menu->is_public && auth()->check())) {
            return $next($request);
        }

        return redirect()->route('login')
            ->with('error', 'Anda tidak memiliki akses ke menu ini');
    }
}
