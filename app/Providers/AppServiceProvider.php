<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\AwsS3V3\PortableVisibilityConverter;
use League\Flysystem\Filesystem;
use League\Flysystem\Visibility;
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
        // Configure R2 storage without ACL headers
        Storage::extend('r2-no-acl', function ($app, $config) {
            $client = new S3Client([
                'credentials' => [
                    'key' => $config['key'],
                    'secret' => $config['secret'],
                ],
                'region' => $config['region'],
                'version' => 'latest',
                'endpoint' => $config['endpoint'],
                'use_path_style_endpoint' => $config['use_path_style_endpoint'] ?? false,
            ]);

            $adapter = new AwsS3V3Adapter(
                $client,
                $config['bucket'],
                '',
                new PortableVisibilityConverter(
                    Visibility::PUBLIC
                )
            );

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
        
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
        
        // Enable query result caching for production
        if (config('app.env') === 'production') {
            DB::enableQueryLog();
        }
    }
}
