<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'molongui_edit_main_query_only', function( $default, &$query )
{
    global $wp_query;
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 20 );
    if ( empty( $dbt ) ) return $default;
    if ( ( $query->is_home() or $query->is_author() )
         and ( $query->query_vars['post_type'] == 'post' or $query->query_vars['post_type'] == 'any' )
         and ( ( isset( $dbt[9]['function'] ) and $dbt[9]['function'] == 'mk_wp_query' ) or ( isset( $dbt[10]['function'] ) and $dbt[10]['function'] == 'mk_wp_query' ) or ( isset( $dbt[13]['function'] ) and $dbt[13]['function'] == 'mk_wp_query' ) )
    )
    {
        $query->set( 'author', $wp_query->get( 'author' ) );             // Set author ID.
        $query->set( 'author_name', $wp_query->get( 'author_name' ) );   // Re-set 'author_name' query_var.
        $query->query['author_name'] = $wp_query->get( 'author_name' );  // Re-set 'author_name' query string.
        return false;
    }
    if ( isset( $wp_query->is_guest_author )
         and $query->is_home()
         and $query->query_vars['post_type'] == 'any'
    )
    {
        $query->set( 'guest-author-name', $wp_query->get( 'guest-author-name' ) );  // Set 'guest-author-name' query string.
        $query->query['guest-author-name'] = $wp_query->get( 'guest-author-name' ); // Set 'guest-author-name' query_var.
        $query->set( 'post_type', 'post' );
        $query->query['post_type'] = 'post';
        $query->set( 'ignore_sticky_posts', true );
        return false;
    }
    return $default;
}, 10, 2 );
add_filter( 'mk_theme_page_header_title', function( $title )
{
    if ( is_author() )
    {
        if ( get_query_var( 'author_name' ) )
        {
            $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
            $title  = $author->display_name;
        }
        else
        {
            $author = get_userdata( get_query_var( 'author' ) );
            $title  = $author->display_name;
        }
    }

    return $title;
});
add_filter( 'mk_theme_page_header_subtitle', function( $subtitle )
{
    if ( is_author() )
    {
        if ( get_query_var( 'author_name' ) )
        {
            $author   = get_user_by( 'slug', get_query_var( 'author_name' ) );
            $subtitle = sprintf( esc_html__( 'Author Archive for: "%s"', 'mk_framework' ), $author->display_name );
        }
        else
        {
            $author   = get_userdata( get_query_var( 'author' ) );
            $subtitle = sprintf( esc_html__( 'Author Archive for: "%s"', 'mk_framework' ), $author->display_name );
        }
    }

    return $subtitle;
});