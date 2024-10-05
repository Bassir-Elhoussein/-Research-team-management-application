<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;
    $dbt = $args['dbt'];

    $fn   = 'get_userdata';
    $file = '/sfwd-lms/themes/ld30/templates/focus/masthead.php';
    if ( $i = array_search( $fn, array_column( $dbt, 'function' ) ) )
    {
        if ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0 )
        {
            $filter = false;
        }
    }
    return array( $filter, $user );
}, 10, 2 );
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;
    $dbt = $args['dbt'];

    $fn = 'learndash_notifications_shortcode_init';
    if ( $key = array_search( $fn, array_column( $dbt, 'function' ) ) )
    {
        $filter = false;
    }
    return array( $filter, $user );
}, 10, 2 );