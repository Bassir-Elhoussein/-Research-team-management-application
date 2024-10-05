<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/get_user_by/aim', function( $aim, $user, $args )
{
    $fn = 'csco_get_post_meta';
    if ( $key = array_search( $fn, array_column( $args['dbt'], 'function' ) ) ) $aim = 'byline';
    return $aim;
}, 10, 3 );