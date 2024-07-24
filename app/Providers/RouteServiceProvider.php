<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->namespace($this->namespace)
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });

        Route::middleware('web')
            ->middlewareGroup('checkUserSession', [
                \App\Http\Middleware\CheckUserSession::class,
            ]);
    }
}
