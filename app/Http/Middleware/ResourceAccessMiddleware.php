<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ResourceAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        // For admin, allow all actions
        if ($user->isAdmin()) {
            return $next($request);
        }

        // For teachers and students, only allow read operations
        $method = $request->method();

        // Allow read operations (GET, HEAD, OPTIONS)
        if (in_array(strtoupper($method), ['GET', 'HEAD', 'OPTIONS'])) {
            // But block create, update, delete related routes (POST, PUT, PATCH, DELETE)
            $routeAction = $request->route()->getAction();
            $actionName = $routeAction['as'] ?? '';

            // Block specific non-read operations
            $actionMethods = [
                'store',    // POST for creating
                'update',   // PUT/PATCH for updating
                'destroy'   // DELETE for deleting
            ];

            $controllerAction = $routeAction['uses'] ?? '';
            if (is_string($controllerAction) && !empty($controllerAction)) {
                // Extract method name from controller@method format
                if (strpos($controllerAction, '@') !== false) {
                    $method = explode('@', $controllerAction)[1];
                    if (in_array($method, $actionMethods)) {
                        abort(403, 'Access denied. Only read operations are allowed for your role.');
                    }
                }
            }

            return $next($request);
        }

        // Deny write operations for non-admins
        if (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            abort(403, 'Access denied. Only read operations are allowed for your role.');
        }

        return $next($request);
    }
}
