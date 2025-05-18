<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Make sure the view paths are properly set
        $this->app['config']->set('view.paths', [
            resource_path('views'),
        ]);
        
        $this->app['config']->set('view.compiled', storage_path('framework/views'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Redirect to a static page if database connection fails
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            Log::error('Database connection failed: ' . $e->getMessage());
            
            // Fallback to static content in case of database failure
            if (request()->path() !== '/') {
                View::share('dbConnectionError', true);
            }
        }
    }
}
