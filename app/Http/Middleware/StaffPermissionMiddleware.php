<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffPermissionMiddleware
{
    /**
     * Handle an incoming request.
     * Check if user has required permission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        // Check if user has the required permission
        if (!$user->hasPermission($permission)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Bạn không có quyền thực hiện hành động này.'], 403);
            }
            return redirect()->route('admin.dashboard')->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }

        return $next($request);
    }
}
