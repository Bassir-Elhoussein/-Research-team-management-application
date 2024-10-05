<?php
defined( 'ABSPATH' ) or exit;
function authorship_update_counters()
{
    check_ajax_referer( 'authorship_update_counters_nonce', 'nonce', true );
    if ( apply_filters( 'authorship/check_wp_cron', true ) and ( defined( 'DISABLE_WP_CRON' ) and DISABLE_WP_CRON ) )
    {
        $result = 'cron_disabled';
    }
    else
    {
        $result = authorship_update_post_counters();
    }
    echo json_encode( is_wp_error( $result ) ? 'false' : $result );
    wp_die();
}
add_action( 'wp_ajax_authorship_update_counters', 'authorship_update_counters' );
function authorship_clear_cache_action()
{
    check_ajax_referer( 'authorship_clear_cache_nonce', 'nonce', true );
    authorship_clear_cache();
    echo json_encode( true );
    wp_die();
}
add_action( 'wp_ajax_authorship_clear_cache_action', 'authorship_clear_cache_action' );