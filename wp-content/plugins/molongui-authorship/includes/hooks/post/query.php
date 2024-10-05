<?php
defined( 'ABSPATH' ) or exit;
if ( !authorship_byline_takeover() ) return;
function authorship_filter_user_posts( $wp_query )
{
    if ( isset( $wp_query->is_guest_author ) ) return;
    if ( molongui_is_request( 'admin' ) )
    {
        $current_screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
        if ( !isset( $current_screen->id ) ) return;

        if ( !( $wp_query->is_author and in_array( $current_screen->id, molongui_enabled_post_screens( MOLONGUI_AUTHORSHIP_PREFIX, 'all' ) ) ) ) return;
    }
    if ( !$wp_query->is_main_query() and apply_filters_ref_array( 'molongui_edit_main_query_only', array( true, &$wp_query ) ) ) return;
    if ( $wp_query->is_author )
    {
        if ( !empty( $wp_query->query_vars['author'] ) )
        {
            $author_id = $wp_query->query_vars['author'];
        }
        else
        {
            $author = get_users( array( 'nicename' => $wp_query->query_vars['author_name'] ) );
            if ( !$author ) return;

            $author_id = $author[0]->ID;
        }
        authorship_add_author_meta_query( $wp_query, 'user', $author_id );
        add_filter( '_authorship/posts_where', '__return_true' );
    }
}
add_action( 'pre_get_posts', 'authorship_filter_user_posts', 999 );
function authorship_remove_author_from_where_clause( $where, $wp_query )
{
    if ( apply_filters( '_authorship/posts_where', false ) )
    {
        if ( !empty( $wp_query->query_vars['author'] ) )
        {
            global $wpdb;
            $where = str_replace( ' AND '.$wpdb->posts.'.post_author IN ('.$wp_query->query_vars['author'].')', '', $where );
            $where = str_replace( ' AND ('.$wpdb->posts.'.post_author = '.$wp_query->query_vars['author'].')' , '', $where );
        }
    }
    return $where;
}
add_filter( 'posts_where', 'authorship_remove_author_from_where_clause', 10, 2 );