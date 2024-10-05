<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'get_the_author_display_name', function( $default )
{
    $i  = 4;
    $fn = 'saswp_author_output';
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 6 );
    if ( isset( $dbt[$i]['function'] ) and ( $dbt[$i]['function'] == $fn ) )
    {
        return authorship_filter_archive_title( $default );
    }
    return $default;
}, 10, 2 );
add_filter( 'authorship/filter_author_link', function( $default, &$args )
{
    $i  = 4;
    $fn = 'saswp_author_output';
    if ( ( is_author() or is_guest_author() ) and isset( $args['dbt'][$i]['function'] ) and ( $args['dbt'][$i]['function'] == $fn ) )
    {
        $args['link'] = authorship_filter_author_page_link( $args['link'] );
        return true;
    }
    return $default;
}, 10, 2 );
add_filter( 'saswp_modify_breadcrumb_output', function( $input )
{
    if ( is_author() or is_guest_author() )
    {
        $input['@id'] = authorship_filter_author_page_link( $input['@id'] ).'#breadcrumb';
        $input['itemListElement']['1']['item']['@id']  = authorship_filter_author_page_link( $input['itemListElement']['1']['@id'] );
        $input['itemListElement']['1']['item']['name'] = authorship_filter_archive_title( $input['itemListElement']['1']['name'] );
    }

    return $input;
});