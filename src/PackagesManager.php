<?php

namespace Heshamfouda\PackagesManager;

use Heshamfouda\PackagesManager\Events\ManagerEvent;
use Illuminate\Support\Facades\App;
use ReflectionClass;
use ReflectionException;

class PackagesManager
{
    /**
     * Application system version
     */
    public const VERSION = '1.0.0';

    /**
     * @var PackageLoader[] Loaded Packages
     */
    protected array $packages = [];

    public function __construct()
    {
        $this->event("Packages Manager V" . $this::VERSION . " Initiated");
        $this->boot();
    }

    /**
     * First Spark when the manager booted
     * @throws ReflectionException
     */
    protected function boot()
    {
        // load all apps into the local container
        $this->injectAppPackages();

        // Load all app preferences
        $this->loadPreferences();
    }

    /**
     * Required to be used in associate with the facade in /routes/web.php file in order to register the packages routes
     */
    public function registerRoutes()
    {
        $this->event("Packages Routes Registered.");
    }

    /**
     * Dispatch internal event usually used for debugging
     *
     * @param string $message The Message
     * @param array $data Any data might be parsed by listeners
     * @param string $type PSR-3 (emergency, alert, critical, error, warning, notice, info, debug, log)
     * @return array|bool|null
     */
    public function event($message, $data = [], $type = 'info')
    {
        return config('packages-manager.events.dispatch') ?
            event(new ManagerEvent(compact('message', 'data', 'type'))) : true;
    }

    /**
     * Inject the registered app packages
     * @todo: Validate Class in properly implemented
     * @todo: validate packages is in array format
     * @todo: Validate Class existence
     */
    protected function injectAppPackages()
    {
        foreach (array_merge(config('packages-manager.packages'), (App::runningInConsole() ? [] : [

        ])) as $packageClass) {
            if (class_exists($packageClass)) {
                $packageName = (new ReflectionClass($packageClass))->getShortName();
                $this->packages[$packageName] = new $packageClass($this);
                $this->event("Package \"{$packageName}\" injected");
            }
        }
    }

    /**
     * List of all loaded packages into the Manager's container
     * @return PackageLoader[]
     */
    public function getLoadedPackages(): array
    {
        return array_filter($this->packages, function ($package, $packageName) {
            return ! str_starts_with(get_class($package), 'Heshamfouda\\PackagesManager');
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * List of all loaded packages into the Manager's container
     * @return string[]
     */
    public function getLoadedPackagesName(): array
    {
        return array_map(function (PackageLoader $package) {
            return get_class($package);
        }, array_values($this->getLoadedPackages()));
    }

    /**
     * List of all loaded packages into the Manager's container
     * @param string $packageName
     * @return bool
     */
    public function isPackageLoaded(string $packageName): bool
    {
        return array_search($packageName, array_map(function (PackageLoader $package) {
            return get_class($package);
        }, array_values($this->packages))) !== false;
    }

    public function loadPreferences()
    {
        $this->event('Loaded Global Application Events!');
    }
}
