<?php

namespace Heshamfouda\PackagesManager;

use Barryvdh\Debugbar\LaravelDebugbar;
use DebugBar\DataCollector\MessagesCollector;
use Exception;
use Heshamfouda\PackagesManager\Listeners\SendEventDataToDebugBar;
use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PackagesManagerServiceProvider extends PackageServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the application services.
     *
     * @return void
     * @throws InvalidPackage
     */
    public function register()
    {
        parent::register();

        if ($this->debugBarLoaded())
            $this->registerDebugBarEventProvider();
    }

    private function debugBarLoaded()
    {
        return app()->environment('local') && class_exists(LaravelDebugbar::class);
    }

    private function registerDebugBarEventProvider()
    {
        $this->app->singleton(SendEventDataToDebugBar::class, function () {
            return new SendEventDataToDebugBar(
                new MessagesCollector('framework_event_logs')
            );
        });
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name('packages-manager')->hasConfigFile();
    }
}
