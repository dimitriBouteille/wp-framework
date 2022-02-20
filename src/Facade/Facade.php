<?php

namespace Dbout\Wp\Framework\Facade;

/**
 * Class Facade
 * @package Dbout\Wp\Framework\Facade
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
abstract class Facade
{

    /**
     * @return null
     */
    protected static function instance()
    {
        return null;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $instance = static::instance();
        if (!$instance) {
            throw new \Exception('A facade instance has not been set.');
        }

        return $instance->$name(...$arguments);
    }
}
