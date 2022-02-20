<?php

namespace Dbout\Wp\Framework\Helper;

/**
 * Class UploadDir
 * @package Dbout\Wp\Framework\Helper
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class UploadDir
{

    /**
     * @return string
     */
    public static function path(): string
    {
        return self::getProperty('path');
    }

    /**
     * @return string
     */
    public static function url(): string
    {
        return self::getProperty('url');
    }

    /**
     * @return string
     */
    public static function subDir(): string
    {
        return self::getProperty('subdir');
    }

    /**
     * @return string
     */
    public static function baseDir(): string
    {
        return self::getProperty('basedir');
    }

    /**
     * @return string
     */
    public static function baseUrl(): string
    {
        return self::getProperty('baseurl');
    }

    /**
     * @param string $name
     * @return string|null
     */
    protected static function getProperty(string $name): ?string
    {
        $data = wp_upload_dir();
        if(key_exists($name, $data)) {
            return $data[$name];
        }

        return null;
    }
}
