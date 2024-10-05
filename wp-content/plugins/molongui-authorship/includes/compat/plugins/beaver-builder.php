<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/get_user_by/aim', function( $aim, $user, $args )
{
    $fn   = 'get_the_author_meta';
    $file = '/bb-plugin/modules/post-grid/includes/post-feed.php';
    if ( $key = array_search( $fn, array_column( $args['dbt'], 'function' ) ) and
        isset( $args['dbt'][$key]['file'] ) and substr_compare( $args['dbt'][$key]['file'], $file, strlen( $args['dbt'][$key]['file'] )-strlen( $file ), strlen( $file ) ) === 0
    ){
        return 'byline';
    }

    return $aim;
}, 10, 3 );