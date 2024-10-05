<?php
defined( 'ABSPATH' ) or exit;
if ( !function_exists( 'molongui_get_plugin_settings' ) )
{
    function molongui_get_plugin_settings( $id = '', $names = '' )
    {
        if ( empty( $id ) or empty( $names ) ) return;
        $settings = array();
        if ( is_array( $names ) ) foreach ( $names as $name ) $settings = array_merge( $settings, (array) get_option( molongui_get_constant( $id, $name.'_SETTINGS' ) ) );
        else $settings = get_option( molongui_get_constant( $id, $names.'_SETTINGS' ) );
        return $settings;
    }
}
if ( !function_exists( 'molongui_is_active' ) )
{
    function molongui_is_active( $plugin_dir )
    {
        return authorship_pro_is_active();
    }
}