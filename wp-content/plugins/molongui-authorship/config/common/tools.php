<?php
defined( 'ABSPATH' ) or exit;

$fw_tools = array();

if ( apply_filters( 'authorship/options/add_common_tools', true ) )
{
    $fw_tools[] = array
    (
        'display' => true,
        'type'    => 'section',
        'id'      => MOLONGUI_AUTHORSHIP_PREFIX . '_tools',
        'name'    => __( 'Tools' ),
    );
    $fw_tools[] = array
    (
        'display' => true,
        'type'    => 'header',
        'label'   => __( "Plugin Settings", 'molongui-authorship' ),
        'buttons' => array(),
    );
    $fw_tools[] = array
    (
        'display' => true,
        'type'    => 'export',
        'class'   => 'is-compact',
        'label'   => __( "Export plugin configuration to have a backup or restore it on another installation", 'molongui-authorship' ),
        'button'  => array
        (
            'display'  => true,
            'id'       => 'export_options',
            'label'    => __( "Backup", 'molongui-authorship' ),
            'title'    => __( "Backup Plugin Configuration", 'molongui-authorship' ),
            'class'    => 'm-export-options same-width',
            'disabled' => false,
        ),
    );
    $plugin_tools   = array();
    $plugin_tools[] = array
    (
        'display' => apply_filters( 'authorship/options/display_banners', true ),
        'type'    => 'banner',
        'class'   => '',
        'default' => '',
        'id'      => 'import_options',
        'title'   => __( "Easily import previously saved plugin configuration with just 1 click", 'molongui-authorship' ),
        'desc'    => '',
        'button'  => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade same-width',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );
    $plugin_tools[] = array
    (
        'display' => apply_filters( 'authorship/options/display_banners', true ),
        'type'    => 'banner',
        'class'   => '',
        'default' => '',
        'id'      => 'import_options',
        'title'   => __( "Reset plugin settings to their defaults", 'molongui-authorship' ),
        'desc'    => '',
        'button'  => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade same-width',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );
    $fw_tools = array_merge( $fw_tools, apply_filters( 'authorship/options/common_tools', $plugin_tools ) );
}