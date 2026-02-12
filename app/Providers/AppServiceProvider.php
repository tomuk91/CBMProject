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

        // Prevent N+1 queries in development (strict mode)
        if (config('app.env') === 'local') {
            \Illuminate\Database\Eloquent\Model::preventLazyLoading();
        }

        // Log slow queries in production (queries > 500ms)
        if (config('app.env') === 'production') {
            DB::listen(function ($query) {
                if ($query->time > 500) {
                    Log::warning('Slow Query Detected', [
                        'sql' => $query->sql,
                        'bindings' => $query->bindings,
                        'time' => $query->time . 'ms',
                    ]);
                }
            });
        }
    }
}
