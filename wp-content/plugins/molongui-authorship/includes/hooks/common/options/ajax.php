<?php
defined( 'ABSPATH' ) or exit;
function authorship_save_options()
{
    if ( !isset( $_POST['nonce'] ) ) return;
    if ( !wp_verify_nonce( $_POST['nonce'], 'mfw_save_options_nonce' ) ) return;
    $options = wp_unslash( $_POST['data'] );

    if ( isset( $options ) and is_array( $options ) )
    {
        $options['plugin_version'] = MOLONGUI_AUTHORSHIP_VERSION;
        $current = (array) get_option( MOLONGUI_AUTHORSHIP_PREFIX.'_options', array() );
        $options = array_merge( $current, $options );
        $options = apply_filters( 'authorship/validate_options', $options, $current );
        update_option( MOLONGUI_AUTHORSHIP_PREFIX.'_options', $options );

        $old = $current;
        do_action( 'authorship/options', $options, $old );
    }
    wp_die();
}
add_action( 'wp_ajax_'.MOLONGUI_AUTHORSHIP_PREFIX.'_save_options', 'authorship_save_options' );
function authorship_export_options()
{
    $options = authorship_get_config();
    $options['plugin_id']      = MOLONGUI_AUTHORSHIP_PREFIX;
    $options['plugin_version'] = MOLONGUI_AUTHORSHIP_VERSION;
    $options = apply_filters( 'authorship/export_options', $options );
    echo json_encode( $options );
    wp_die();
}
add_action( 'wp_ajax_'.MOLONGUI_AUTHORSHIP_PREFIX.'_export_options', 'authorship_export_options' );