<?php
defined( 'ABSPATH' ) or exit;
function authorship_get_debug_data( $format = 'info' )
{
    if ( !class_exists( 'WP_Debug_Data' ) ) require_once ABSPATH . 'wp-admin/includes/class-wp-debug-data.php';
    $data = WP_Debug_Data::debug_data();
    if ( !empty( $format ) ) $data = WP_Debug_Data::format( $data, $format );
    return $data;
}