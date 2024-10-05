<?php
defined( 'ABSPATH' ) or exit;
function authorship_get_upsells()
{
    $upsells = include MOLONGUI_AUTHORSHIP_DIR . 'config/common/upsells.php';
    if ( empty( $upsells ) ) return false;
    foreach ( get_molongui_plugins( 'keys' ) as $plugin_file ) unset( $upsells[$plugin_file] );
    return $upsells;
}