<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'um_profile_query_make_posts', 'authorship_um_add_coauthored_1', 10, 1 );
add_filter( 'posts_where'                , 'authorship_um_add_coauthored_2', 10, 2 );
function authorship_um_add_coauthored_1( $args )
{
    $author = $args['author'];
    $meta_query[] = array
    (
        array
        (
            'key'     => '_molongui_author',
            'value'   => 'user-'.$author,
            'compare' => '==',
        ),
    );
    $args['meta_query'] = !empty( $args['meta_query'] ) ? array_merge( $args['meta_query'], $meta_query ) : $meta_query;
    $args['suppress_filters'] = false;
    return $args;
}
function authorship_um_add_coauthored_2( $where, $wp_query )
{
    if ( !um_is_core_page( 'user' ) ) return $where;
    if ( !empty( $wp_query->query_vars['author'] ) )
    {
        global $wpdb;
        $where = str_replace( ' AND '.$wpdb->posts.'.post_author IN ('.$wp_query->query_vars['author'].')', '', $where );
        $where = str_replace( ' AND ('.$wpdb->posts.'.post_author = '.$wp_query->query_vars['author'].')' , '', $where );
        $where = str_replace( $wpdb->postmeta.'.post_id IS NULL ', '( '.$wpdb->postmeta.'.post_id IS NULL AND '.$wpdb->posts.'.post_author = '.$wp_query->query_vars['author'].' )', $where );
    }
    return $where;
}