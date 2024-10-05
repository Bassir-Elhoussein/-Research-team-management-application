<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'molongui_authorship_bypass_original_user_id_if', function( $default )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    $fns = array( 'post_meta_1', 'post_meta_3', 'jnews_the_author_link' );
    foreach ( $fns as $fn ) if ( array_search( $fn, array_column( $dbt, 'function' ) ) ) return true;
    return $default;
});
add_filter( 'molongui_authorship_filter_the_author_display_name_post_id', function( $post_id, $post, $display_name )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 8 );
    $fns   = array( 'post_meta_1', 'post_meta_3' );
    $class = 'JNews\Module\ModuleViewAbstract';
    foreach ( $fns as $fn ) if ( $i = array_search( $fn, array_column( $dbt, 'function' ) ) )
    {
        if ( isset( $dbt[$i]['class'] ) and $dbt[$i]['class'] == $class )
        {
            if ( isset( $dbt[$i]['object'] ) and isset( $dbt[$i]['args'][0] ) and isset( $dbt[$i]['args'][0]->ID ) )
            {
                return (int) $dbt[$i]['args'][0]->ID;
            }
        }
    }
    return $post_id;
}, 10, 3 );
add_filter( 'molongui_authorship_filter_link_post_id', function( $post_id, $post, $link )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 9 );
    $i     = 8;
    $fns   = array( 'post_meta_1', 'post_meta_3' );
    $class = 'JNews\Module\ModuleViewAbstract';
    foreach ( $fns as $fn ) if ( $i = array_search( $fn, array_column( $dbt, 'function' ) ) )
    {
        if ( isset( $dbt[$i]['class'] ) and $dbt[$i]['class'] == $class )
        {
            if ( isset( $dbt[$i]['object'] ) and isset( $dbt[$i]['args'][0] ) and isset( $dbt[$i]['args'][0]->ID ) )
            {
                return (int) $dbt[$i]['args'][0]->ID;
            }
        }
    }
    return $post_id;
}, 10, 3 );
add_filter( 'authorship/render_box', function( $default )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    if ( in_the_loop() and isset( $dbt[7]['function'] ) and $dbt[7]['function'] == "render_footer" and isset( $dbt[7]['class'] ) and $dbt[7]['class'] == "JNews\Footer\FooterBuilder" ) return false;
    return $default;
});
add_filter( 'jnews_default_query_args', function( $args )
{
    global $wp_query;
    if ( is_admin() or !$wp_query->is_main_query() ) return $args;
    if ( empty( $wp_query->get( 'meta_query' ) ) ) return $args;
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 15 );
    if ( is_author() or is_guest_author() )
    {
        $fn    = 'render_content';
        $class = 'JNews\Archive\AuthorArchive';

        if ( $key = array_search( $fn, array_column( $dbt, 'function' ) ) and isset( $dbt[$key]['class'] ) and ( $dbt[$key]['class'] == $class ) )
        {
            if ( is_guest_author() ) unset( $args['author__in'] );
            $args['meta_query'] = $wp_query->get( 'meta_query' );
        }
    }

    return $args;
}, 99, 1 );
add_filter( 'molongui_authorship_dont_filter_the_author_display_name', function( $default, $display_name, $user_id, $original_user_id, $post, $dbt )
{
    $fn    = 'top_bar_account';
    $class = 'FirstLoadAction';
    if ( $i = array_search( $fn, array_column( $dbt, 'function' ) ) ) return true;
    if ( $i = array_search( $class, array_column( $dbt, 'class' ) ) ) return true;
    return $default;
}, 10, 6 );
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    $fn    = 'top_bar_account';
    $class = 'FirstLoadAction';
    list( $filter, $user ) = $data;
    if ( $i = array_search( $fn, array_column( $args['dbt'], 'function' ) ) ) $filter = false;
    if ( $i = array_search( $class, array_column( $args['dbt'], 'class' ) ) ) return true;
    return array( $filter, $user );
}, 10, 2 );
add_filter( 'authorship/get_avatar_data/skip', function( $default, $avatar, $dbt )
{
    $fn    = 'top_bar_account';
    $class = 'FirstLoadAction';
    if ( $i = array_search( $fn, array_column( $dbt, 'function' ) ) ) return true;
    if ( $i = array_search( $class, array_column( $dbt, 'class' ) ) ) return true;
    return $default;
}, 10, 3 );