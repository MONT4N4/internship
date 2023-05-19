<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Allow CORS requests from any origin and with any headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');

        // Register the Sanctum middleware for stateful authentication
        $this->app->make('router')->aliasMiddleware('auth', EnsureFrontendRequestsAreStateful::class);

        // Format JSON responses using the JsonResource class
        JsonResource::withoutWrapping();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
