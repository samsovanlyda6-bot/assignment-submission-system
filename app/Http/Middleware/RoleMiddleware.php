<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    // Role ID constants – easy to maintain
    const ROLE_ADMIN = 1;
    const ROLE_TEACHER = 2;
    const ROLE_STUDENT = 3;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles  Comma‑separated list of allowed roles (e.g., "admin,teacher")
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // If no roles are specified, allow everyone (optional)
        if (empty($roles)) {
            return $next($request);
        }

        // If user is not logged in, redirect to login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        $userRoleId = Auth::user()->role_id;

        // Build an array of allowed role IDs based on the given role names
        $allowedRoleIds = [];
        foreach ($roles as $roleGroup) {
            // Split by comma in case a single string contains multiple roles
            $roleNames = explode(',', $roleGroup);
            foreach ($roleNames as $roleName) {
                $roleId = $this->getRoleId($roleName);
                if ($roleId !== null) {
                    $allowedRoleIds[] = $roleId;
                }
            }
        }

        // If user's role is allowed, proceed
        if (in_array($userRoleId, $allowedRoleIds)) {
            return $next($request);
        }

        // User is authenticated but does not have the required role
        // Redirect to their appropriate dashboard (or home) with a flash message
        $dashboardRoute = $this->getDashboardRouteForRole($userRoleId);

        return redirect()->route($dashboardRoute)
            ->with('error', 'You do not have permission to access that page.');
    }

    /**
     * Convert role name to role ID using constants or database lookup.
     *
     * @param  string  $roleName
     * @return int|null
     */
    private function getRoleId(string $roleName): ?int
    {
        return match (strtolower($roleName)) {
            'admin'  => self::ROLE_ADMIN,
            'teacher'=> self::ROLE_TEACHER,
            'student'=> self::ROLE_STUDENT,
            default  => null,
        };
    }

    /**
     * Get the appropriate dashboard route name for a user based on their role ID.
     *
     * @param  int  $roleId
     * @return string
     */
    private function getDashboardRouteForRole(int $roleId): string
    {
        return match ($roleId) {
            self::ROLE_ADMIN   => 'admin.dashboard',
            self::ROLE_TEACHER => 'teacher.dashboard',
            self::ROLE_STUDENT => 'student.dashboard',
            default            => 'dashboard',
        };
    }
}
