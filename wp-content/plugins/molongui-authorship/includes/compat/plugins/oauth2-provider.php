<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;
    $dbt = $args['dbt'];
    $fns = array
    (
        'wo_personal_data_erase_function',   //
        'wo_personal_data_export_function',  //
        'wpoauth_method_introspection',      //
        'wpoauth_method_me',                 //
    );

    if ( array_intersect( $fns, array_column( $dbt, 'function' ) ) ) return array( false, $user );

    if ( $i = array_search( 'getUser', array_column( $dbt, 'function' ) ) and
         isset( $dbt[$i]['class'] ) and ( $dbt[$i]['class'] == 'WPOAuth2\Storage\Wordpressdb' ) )
    {
        return array( false, $user );
    }

    if ( $i = array_search( 'get_user_by', array_column( $dbt, 'function' ) ) )
    {
        $file = 'library/class-wo-api.php';
        if ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0 )
        {
            return array( false, $user );
        }
    }

    return array( $data, $user );

}, 10, 2 );