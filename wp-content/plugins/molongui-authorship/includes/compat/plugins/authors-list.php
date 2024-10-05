<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;

    $fn = 'authors_list_sc';
    if ( $i = array_search( $fn, array_column( $args['dbt'], 'function' ) ) ) $filter = false;

    return array( $filter, $user );
}, 10, 2 );
add_filter( 'authorship/get_the_author_description/skip', function ( $default, $description, $user_id, $original_user_id )
{
    $fn  = 'authors_list_sc';
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );

    if ( $i = array_search( $fn, array_column( $dbt, 'function' ) ) ) return true;
    return $default;
}, 10, 4 );
add_filter( 'authorship/filter_author_link', function( $default, &$args )
{
    $fn  = 'authors_list_sc';

    if ( $i = array_search( $fn, array_column( $args['dbt'], 'function' ) ) ) return true;
    return $default;
}, 10, 2 );