<?php
defined( 'ABSPATH' ) or exit;
function authorship_guest_query_var( $query_vars )
{
    $query_vars[] = 'guest';

    return $query_vars;
}
add_action( 'query_vars', 'authorship_guest_query_var' );
function authorship_filter_guest_posts( $wp_query )
{
    if ( !molongui_is_request( 'admin' ) ) return false;
    $qv = $wp_query->query_vars;
    if ( empty( $qv['guest'] ) ) return false;
    $meta_query = $wp_query->get( 'meta_query' );
    if ( !is_array( $meta_query ) and empty( $meta_query ) ) $meta_query = array();
    $meta_query[] = array
    (
        array
        (
            'key'     => '_molongui_author',
            'value'   => 'guest-'.$qv['guest'],
            'compare' => '==',
        ),
    );
    $wp_query->set( 'meta_query', $meta_query );
}
add_action( 'pre_get_posts', 'authorship_filter_guest_posts', 999 );