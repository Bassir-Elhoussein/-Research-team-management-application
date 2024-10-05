<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
{
    if ( $leave ) return $leave;
    if ( ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_the_author' )
            and
            isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'cr_page_title' ) )
        or
        ( isset( $args['dbt'][5]['function'] ) and ( $args['dbt'][5]['function'] == 'the_author_posts_link' )
            and
            isset( $args['dbt'][5]['file'] ) and substr_compare( $args['dbt'][5]['file'], '/themes/creativo/archive.php', strlen( $args['dbt'][5]['file'] )-strlen( '/themes/creativo/archive.php' ), strlen( '/themes/creativo/archive.php' ) ) === 0 )
        or
        ( isset( $args['dbt'][6]['function'] ) and ( $args['dbt'][6]['function'] == 'the_author_posts_link' )
            and
            isset( $args['dbt'][6]['file'] ) and substr_compare( $args['dbt'][6]['file'], '/themes/creativo/archive.php', strlen( $args['dbt'][6]['file'] )-strlen( '/themes/creativo/archive.php' ), strlen( '/themes/creativo/archive.php' ) ) === 0 )
    )
    {
        $args['display_name'] = authorship_filter_archive_title( $args['display_name'] );
        return true;
    }
    return false;
}, 10, 2 );
add_filter( 'authorship/filter_author_link', function( $leave, &$args )
{
    if ( $leave ) return $leave;
    if ( isset( $args['dbt'][5]['function'] ) and ( $args['dbt'][5]['function'] == 'the_author_posts_link' )
        and
        isset( $args['dbt'][5]['file'] ) and substr_compare( $args['dbt'][5]['file'], '/themes/creativo/archive.php', strlen( $args['dbt'][5]['file'] )-strlen( '/themes/creativo/archive.php' ), strlen( '/themes/creativo/archive.php' ) ) === 0
    )
    {
        $args['link'] = authorship_filter_author_page_link( $args['link'] );
        return true;
    }
    return false;
}, 10, 2 );