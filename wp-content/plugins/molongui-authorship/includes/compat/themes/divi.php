<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'authorship/render_box', function( $render )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    if ( array_search( 'et_theme_builder_frontend_render_post_content', array_column( $dbt, 'function' ) ) )
    {
        $render = true;
    }

    return $render;
}, 10, 1 );
add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
{
    if ( $leave ) return $leave;
    if ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_the_author' ) and isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'et_builder_get_current_title' ) )
    {
        $args['display_name'] = authorship_filter_archive_title( $args['display_name'] );
        return true;
    }
    return false;
}, 10, 2 );
add_filter( 'molongui_edit_main_query_only', function( $default, &$query )
{
    if ( !$query->is_author() ) return $default;
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 11 );
    if ( empty( $dbt ) ) return $default;
    $fn    = 'render';
    $class = 'ET_Builder_Module_Blog';
    if ( $key = array_search( $fn, array_column( $dbt, 'function' ) ) and
        isset( $dbt[$key]['class'] ) and ( $dbt[$key]['class'] == $class ) )
    {
        return false;
    }
    return $default;
}, 10, 2 );