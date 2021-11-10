<?php

namespace Heshamfouda\PackagesManager;

trait PackageLoaderInterface
{
    /**
     * @var string
     */
    protected string $mainRouteNameSlug;

    /**
     * @var string
     */
    protected string $mainRoutePrefix;

    /**
     * @var array
     */
    protected array $mainRouteMiddleware;

    /**
     * @var PackagesManager
     */
    protected PackagesManager $manager;

    /**
     * List of optional custom view locations in the format of :[['Namespace' => __DIR__ . DIRECTORY_SEPARATOR . 'Views'],]
     * @var array
     */
    protected array $viewLocations = [];

    /**
     * Get Package's Long name
     * @return string
     */
    abstract public function longName(): string;

    /**
     * Get Package's Short name
     * @return string
     */
    abstract public function shortName(): string;


    /**
     * Get package's Slug
     * @return string
     */
    abstract public function slug(): string;

    /**
     * Get package's Description
     * @return string
     */
    abstract public function description(): string;

    /**
     * Define The routes name slug.
     * @return string
     */
    abstract public function routeName(): string;
}
