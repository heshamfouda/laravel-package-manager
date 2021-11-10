<?php

namespace Heshamfouda\PackagesManager;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Heshamfouda\PackagesManager\PackagesManager
 */
class PackagesManagerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PackagesManager::class;
    }
}
