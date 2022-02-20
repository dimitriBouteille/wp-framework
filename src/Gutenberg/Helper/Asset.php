<?php

namespace Dbout\Wp\Framework\Gutenberg\Helper;

/**
 * Class Asset
 * @package Dbout\Wp\Framework\Gutenberg\Helper
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class Asset
{

    /**
     * @param string $blockName
     * @param string $extension
     * @return string
     */
    public static function getBlockAssetUrl(string $blockName, string $extension = '.js'): string
    {
        $basePath = get_stylesheet_directory_uri().'/static/blocks/';
        return $basePath . $blockName . $extension;
    }
}
