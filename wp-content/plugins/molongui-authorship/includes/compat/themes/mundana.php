<?php
defined( 'ABSPATH' ) or exit;
add_action( 'parse_request', function( $wp_query )
{

    if ( !empty( $wp_query->query_vars['guest-author-name'] ) )
    {
        remove_action( 'pre_get_posts', 'mundana_exclude_latest_post', 1 );
        remove_action( 'pre_get_posts', 'mundana_query_offset', 1 );
    }

    return $wp_query;

}, 1, 1 );