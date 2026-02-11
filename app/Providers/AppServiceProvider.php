<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set Carbon locale to match application locale
        Carbon::setLocale(App::getLocale());
        
        // Log slow queries in production (optional - enable if needed)
        if (config('app.env') === 'production' && config('app.debug') === true) {
            DB::listen(function ($query) {
                if ($query->time > 1000) { // Log queries taking more than 1 second
                    Log::warning('Slow Query Detected', [
                        'sql' => $query->sql,
                        'bindings' => $query->bindings,
                        'time' => $query->time . 'ms'
                    ]);
                }
            });
        }
        

    }
}
