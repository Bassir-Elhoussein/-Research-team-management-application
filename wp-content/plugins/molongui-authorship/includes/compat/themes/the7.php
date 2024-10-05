<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
{
    if ( $leave ) return $leave;
    if ( isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'presscore_get_page_title' ) )
    {
        $args['display_name'] = authorship_filter_archive_title( $args['display_name'] );
        return true;
    }
    return false;
}, 10, 2 );
add_filter( 'authorship/filter_author_link', function( $leave, &$args )
{
    if ( $leave ) return $leave;
    if ( isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'presscore_get_page_title' ) )
    {
        $args['link'] = authorship_filter_author_page_link( $args['link'] );
        return true;
    }
    return false;
}, 10, 2 );