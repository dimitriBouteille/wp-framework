<?php

namespace Dbout\Wp\Framework\MuPlugin;

/**
 * Class RemoveEmojiSupport
 * @package Dbout\Wp\Framework\MuPlugin
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class RemoveEmojiSupport
{

    /**
     * @return void
     */
    public static function execute()
    {
        // Front
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');

        // Admin
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');

        // Feeds
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');

        // Embeds
        remove_filter('embed_head', 'print_emoji_detection_script');

        // Disable in database
        if ((int)get_option('use_smilies') === 1) {
            update_option('use_smilies', 0);
        }
    }
}
