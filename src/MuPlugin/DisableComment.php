<?php

namespace Dbout\Wp\Framework\MuPlugin;

/**
 * Class DisableComment
 * @package Dbout\Wp\Framework\MuPlugin
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class DisableComment
{

    /**
     * @return void
     */
    public static function execute()
    {
        add_filter('comments_open', '__return_false');
        add_filter('pings_open', '__return_false');

        add_filter('comments_array', function() {
            return [];
        }, 10, 2);

        add_action('admin_menu', function () {
            remove_menu_page('edit-comments.php');
        });

        add_action('init', function() {
            if(is_admin_bar_showing()) {
                remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
            }
        });
    }
}
