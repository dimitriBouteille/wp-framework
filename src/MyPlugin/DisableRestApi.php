<?php

namespace Dbout\Wp\Framework\MuPlugin;

/**
 * Class DisableRestApi
 * @package Dbout\Wp\Framework\MuPlugin
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class DisableRestApi
{

    /**
     * @return void
     */
    public static function execute(): void
    {
        add_filter('rest_authentication_errors', function($result) {
            if(!is_user_logged_in()) {

                remove_action( 'init', 'rest_api_init' );
                remove_action( 'parse_request', 'rest_api_loaded');

                remove_action( 'xmlrpc_rsd_apis',  'rest_output_rsd');
                remove_action( 'wp_head', 'rest_output_link_wp_head', 10);
                remove_action( 'template_redirect', 'rest_output_link_header', 11);
                remove_action( 'auth_cookie_malformed', 'rest_cookie_collect_status');
                remove_action( 'auth_cookie_expired', 'rest_cookie_collect_status' );
                remove_action( 'auth_cookie_bad_username', 'rest_cookie_collect_status');
                remove_action( 'auth_cookie_bad_hash', 'rest_cookie_collect_status');
                remove_action( 'auth_cookie_valid', 'rest_cookie_collect_status');

                // Remove oEmbed discovery links.
                remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

                add_filter( 'rest_enabled', '__return_false');
                add_filter( 'rest_jsonp_enabled', '__return_false');

                add_filter('rest_authentication_errors', function($result) {
                    if (!empty($result)) {
                        return $result;
                    }

                    if (!is_user_logged_in()) {
                        return new \WP_Error(__('invalid_access', 'Oops, impossible d\'accéder à cette page :('));
                    }
                });
            }
        });
    }
}