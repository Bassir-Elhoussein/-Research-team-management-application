<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'authorship/get_avatar_data/skip', function( $default, $avatar, $dbt )
{
    $i    = 4;
    $fn   = 'get_avatar';
    $file = '/template-parts/header-user-links.php';
    if ( !is_admin() and
         isset( $dbt[$i]['function'] ) and ( $dbt[$i]['function'] == $fn ) and
         isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0
    ) return true;
    return $default;
}, 10, 3 );