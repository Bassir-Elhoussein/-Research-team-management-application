<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
{
    if ( $leave ) return $leave;
    if ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_the_author' )
         and
         isset( $args['dbt'][3]['file'] ) and substr_compare( $args['dbt'][3]['file'], '/themes/parallelus-vellum/author.php', strlen( $args['dbt'][3]['file'] )-strlen( '/themes/parallelus-vellum/author.php' ), strlen( '/themes/parallelus-vellum/author.php' ) ) === 0
    )
    {
        $args['display_name'] = authorship_filter_archive_title( $args['display_name'] );
        return true;
    }
    return false;
}, 10, 2 );
add_filter( 'molongui_edit_main_query_only', function( $default, &$query )
{
    return false;
}, 10, 2 );