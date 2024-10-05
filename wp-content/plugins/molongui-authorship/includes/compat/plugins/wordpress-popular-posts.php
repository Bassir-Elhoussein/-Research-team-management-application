<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'molongui_authorship_bypass_original_user_id_if', function( $default )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    $i     = 7;
    $fn    = 'get_author';
    $class = 'WordPressPopularPosts\Output';
    if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == $fn and
         isset( $dbt[$i]['class'] ) and $dbt[$i]['class'] == $class
    )
        return true;

    return $default;
});
add_filter( 'molongui_authorship_filter_the_author_display_name_post_id', function( $post_id, $post, $display_name )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 8 );
    $i     = 7;
    $fn    = 'get_author';
    $class = 'WordPressPopularPosts\Output';
    if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == $fn and
         isset( $dbt[$i]['class'] ) and $dbt[$i]['class'] == $class and
         isset( $dbt[$i]['object'] ) and isset( $dbt[$i]['args'][0] ) and isset( $dbt[$i]['args'][0]->id )
    )
        return (int) $dbt[$i]['args'][0]->id;
    return $post_id;
}, 10, 3 );
add_filter( 'molongui_authorship_filter_link_post_id', function( $post_id, $post, $link )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 9 );
    $i     = 8;
    $fn    = 'get_metadata';
    $class = 'WordPressPopularPosts\Output';
    if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == $fn and
         isset( $dbt[$i]['class'] ) and $dbt[$i]['class'] == $class and
         isset( $dbt[$i]['object'] ) and isset( $dbt[$i]['args'][0] ) and isset( $dbt[$i]['args'][0]->id )
    )
        return (int) $dbt[$i]['args'][0]->id;
    return $post_id;
}, 10, 3 );