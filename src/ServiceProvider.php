<?php

namespace Coder\LaravelDash;

use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    public function boot()
    {
        $this->publishMigration();

        // $this->publishes([
        //     __DIR__.'/config/laravel-dash.php' => config_path('laravel-dash.php'),
        // ]);
    }

    public function register()
    {
        $this->registerDash();
    }

    private function registerDash()
    {
        $this->app->singleton('dash', function ($app) {
            return new Dash($app);
        });
    }

    public function publishMigration(){
        // Publish migrations
        $migrations = realpath(__DIR__.'/../database/migrations');

        $this->publishes([
            $migrations => $this->app->databasePath().'/migrations',
        ], 'migrations');
    }
}
