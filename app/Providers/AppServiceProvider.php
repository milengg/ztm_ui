<?php

namespace App\Providers;

use App\View\BladeCompiler;
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
        $this->app->bind('blade.compiler', function($app)
        {
            $cache = $app['path.storage'].'/views';
            return new BladeCompiler($app['files'], $cache);

        }, true);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
