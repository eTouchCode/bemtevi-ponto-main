<?php

namespace App\Http\Middleware;

use App\Models\CompanyUser;
use App\Models\EmployeeLogin;
use App\Models\Warnings;
use Cache;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use View;

class NotificationData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        switch (true) {
            case $request->user() instanceof EmployeeLogin:
                $notifications = Cache::remember('notifications', 60 * 60 * 24, function () {
                    return Warnings::where('target', 'company')->orWhere('target', 'employee')->whereBetween('date', [now()->subDays(15)->format('Y-m-d'), now()->format('Y-m-d')])
                        ->orWhereBetween('end_date', [now()->addDays(15)->format('Y-m-d'), now()->format('Y-m-d')])->get();
                });
                break;
            case $request->user() instanceof CompanyUser:
                $notifications = Cache::remember('notifications', 60 * 60 * 24, function () {
                    return Warnings::where('target', 'company')->orWhere('target', 'admin')->whereBetween('date', [now()->subDays(15)->format('Y-m-d'), now()->format('Y-m-d')])
                        ->orWhereBetween('end_date', [now()->addDays(15)->format('Y-m-d'), now()->format('Y-m-d')])->get();
                });
                break;
            default:
                $notifications = null;
                break;
        }

        View::share('notifications', $notifications);

        return $next($request);
    }
}
