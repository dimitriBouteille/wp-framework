<?php

namespace Dbout\Wp\Framework\MuPlugin;

/**
 * Class RemoveGeneratorMetas
 * @package Dbout\Wp\Framework\MuPlugin
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class RemoveGeneratorMetas
{

    /**
     * @return void
     */
    public static function execute()
    {
        remove_action('wp_head', 'wp_generator');
        add_filter('the_generator', '__return_empty_string');
    }
}
