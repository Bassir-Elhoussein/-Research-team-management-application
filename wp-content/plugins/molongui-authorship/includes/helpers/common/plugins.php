<?php
defined( 'ABSPATH' ) or exit;
if ( !function_exists( 'get_molongui_plugins' ) )
{
    function get_molongui_plugins( $field = 'all' )
    {
        if ( !function_exists( 'get_plugins' ) ) require_once ABSPATH . 'wp-admin/includes/plugin.php';
        $plugins = get_plugins();
        if ( version_compare( PHP_VERSION, '5.6.0', '<' ) )
        {
            foreach ( $plugins as $plugin_file => $plugin )
            {
                if ( $plugin['Author'] == 'Molongui' )
                {
                    $molongui_plugins[$plugin_file] = $plugin;
                    $molongui_plugins[$plugin_file]['id'] = get_molongui_id_from_filepath( $plugin_file );
                }
            }
        }
        else
        {
            $molongui_plugins = array_filter( $plugins, function( $value, $key )
            {
                return ( $value['Author'] == 'Molongui' );
            }, ARRAY_FILTER_USE_BOTH);
        }
        if ( $field != 'all' )
        {
            if ( $field == 'keys' ) return array_keys( $molongui_plugins );

            $data = array();
            foreach ( $molongui_plugins as $plugin_file => $plugin )
            {
                $data[$plugin_file] = $plugin[$field];
            }
            $molongui_plugins = $data;
        }
        return $molongui_plugins;
    }
}
if ( !function_exists( 'get_molongui_id_from_filepath' ) )
{
    function get_molongui_id_from_filepath( $filepath )
    {
        if ( !isset( $filepath ) ) return false;
        $plugin_id = explode( '/', $filepath );
        $plugin_id = strtolower( strtr( $plugin_id[0], array( 'molongui-' => '', ' ' => '_', '-' => '_' ) ) );
        if ( $plugin_id == "bump_offer" ) $plugin_id = "order_bump";
        return $plugin_id;
    }
}
if ( !function_exists( 'authorship_has_pro' ) )
{
    function authorship_has_pro()
    {
        return did_action( 'authorship_pro/init' );
    }
}