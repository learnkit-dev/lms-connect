<?php

namespace LearnKit\LmsConnect\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Pennant\Feature;
use LearnKit\LmsConnect\ConnectPlugin;

class PluginEnabledMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $team = $request->route()->parameter('team');

        $isPluginActive = Feature::for($team)->active(ConnectPlugin::class);

        abort_unless($team && $isPluginActive, 404);

        return $next($request);
    }
}
