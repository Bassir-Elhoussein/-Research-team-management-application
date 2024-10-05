<?php
defined( 'ABSPATH' ) or exit;
function authorship_filter_export_options( $options )
{
    unset( $options[MOLONGUI_AUTHORSHIP_PREFIX.'_cache_posts'] );
    unset( $options[MOLONGUI_AUTHORSHIP_PREFIX.'_cache_users'] );
    unset( $options[MOLONGUI_AUTHORSHIP_PREFIX.'_cache_guests'] );

    return $options;
}
add_filter( 'authorship/export_options', 'authorship_filter_export_options' );