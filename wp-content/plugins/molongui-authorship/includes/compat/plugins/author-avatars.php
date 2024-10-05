<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;

    $fn    = 'format_user';
    $class = 'UserList';

    if ( $i = array_search( $fn, array_column( $args['dbt'], 'function' ) ) and
         isset( $args['dbt'][$i]['class'] ) and ( $args['dbt'][$i]['class'] == $class ) )
    {
        $filter = false;
    }

    return array( $filter, $user );
}, 10, 2 );
add_filter( 'authorship/filter_author_link', function( $default, &$args )
{
    $fn    = 'format_user';
    $class = 'UserList';

    if ( $i = array_search( $fn, array_column( $args['dbt'], 'function' ) ) and
         isset( $args['dbt'][$i]['class'] ) and ( $args['dbt'][$i]['class'] == $class ) )
    {
        return true;
    }
    return $default;
}, 10, 2 );
add_filter( 'authorship/get_the_author_description/skip', function ( $default, $description, $user_id, $original_user_id )
{
    $dbt   = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );
    $fn    = 'format_user';
    $class = 'UserList';

    if ( $i = array_search( $fn, array_column( $dbt, 'function' ) ) and
         isset( $dbt[$i]['class'] ) and ( $dbt[$i]['class'] == $class ) )
    {
        return true;
    }
    return $default;
}, 10, 4 );