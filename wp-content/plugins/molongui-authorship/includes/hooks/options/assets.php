<?php
defined( 'ABSPATH' ) or exit;
function authorship_use_cdn()
{
    add_filter( 'authorship/assets/load_remote', function()
    {
        $options = authorship_get_options();
        return !empty( $options['assets_cdn'] );
    });
}
add_action( 'admin_init', 'authorship_use_cdn', 0 );
add_action( 'init', 'authorship_use_cdn', 0 );