<?php

namespace Dbout\Wp\Framework;

use Dbout\Wp\Framework\Api\Routes\AbstractRoute;
use Dbout\WpHooks\Facade\Action;

/**
 * Class RoutesRegistry
 * @package Dbout\Wp\Framework
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class RoutesRegistry
{

    /**
     * @var array
     */
    protected array $routes = [];

    /**
     * @return void
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * @return void
     */
    protected function initialize(): void
    {
    }

    /**
     * @param AbstractRoute $route
     * @return $this
     */
    public function addRoute(AbstractRoute $route): self
    {
        $this->routes[] = $route;
        return $this;
    }

    /**
     * @return void
     */
    public function registerRoutes(): void
    {
        Action::add('rest_api_init', function () {
            foreach ($this->routes as $route) {
                /** @var AbstractRoute $route */
                $route->register();
            }
        });
    }
}
