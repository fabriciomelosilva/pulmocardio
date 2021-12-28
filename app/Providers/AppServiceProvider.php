<?php

namespace App\Providers;

use League\Glide\ServerFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('League\Glide\Server', function ($app){
            $filesystem = $app->make('Illuminate\Contracts\Filesystem\Filesystem');
            return ServerFactory::create([
                'source' => $filesystem->getDriver(),
                'cache' => $filesystem->getDriver(),
                'source_path_prefix' => 'images',
                'cache_path_prefix' => 'images/.cache',
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->environment('development')) {
            \URL::forceScheme('https');
        }
    }
}
