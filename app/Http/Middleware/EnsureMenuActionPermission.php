<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMenuActionPermission
{
    public function handle(Request $request, Closure $next, string $action, string $parameter = 'menu'): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        $menuValue = $request->route($parameter);

        $menuSlug = match (true) {
            $menuValue instanceof Menu => $menuValue->slug,
            is_string($menuValue) => $menuValue,
            default => null,
        };

        if (! $menuSlug || ! $user->can($menuSlug.'.'.$action)) {
            abort(403, 'Akses menu ditolak.');
        }

        return $next($request);
    }
}
