<?php

namespace Dbout\Wp\Framework\Api\Route;

/**
 * Interface InterfaceRoute
 * @package Dbout\Wp\Framework\Api\Route
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
interface InterfaceRoute
{

    /**
     * Register route in WordPress
     * @see https://developer.wordpress.org/reference/functions/register_rest_route/
     * @return void
     * @throws \Exception
     */
    public function register(): void;
}
