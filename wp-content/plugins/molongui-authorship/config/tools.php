<?php
defined( 'ABSPATH' ) or exit;

$tools = array();
if ( true )
{
    $tools[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'section',
        'id'       => MOLONGUI_AUTHORSHIP_PREFIX . '_tools',
        'name'     => __( "Tools" ),
    );
    $tools[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'title',
        'label'    => __( "Convenient tools to easily manage plugin data.", 'molongui-authorship' ),
    );
    $tools[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'tools_authorship_header',
        'label'    => __( "Authorship", 'molongui-authorship' ),
        'buttons'  => array(),
    );
    $authorship_tools[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'authorship_tools',
        'title'    => __( "1-click easy manage post authorship", 'molongui-authorship' ),
        'desc'     => __( "Export, import and reset your posts author configuration. Hasle-free!", 'molongui-authorship' ),
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade same-width',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $tools = array_merge( $tools, apply_filters( '_authorship/options/authorship/tools/markup', $authorship_tools ) );
    $tools[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'button',
        'class'    => 'is-compact',
        'label'    => __( "Force an update of post counters", 'molongui-authorship' ),
        'button'   => array
        (
            'display'  => true,
            'type'     => 'action',
            'id'       => 'update_counters',
            'label'    => __( "Run", 'molongui-authorship' ),
            'title'    => __( "Update post counters", 'molongui-authorship' ),
            'class'    => 'm-update-counters same-width',
            'disabled' => false,
        ),
    );
    $tools[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => 'guest_authors',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'tools_guests_header',
        'label'    => __( "Guest Authors", 'molongui-authorship' ),
        'buttons'  => array(),
    );
    $guest_tools[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'guests_tools',
        'title'    => __( "1-click manage your guest authors", 'molongui-authorship' ),
        'desc'     => __( "Export guest authors to another installation. Import one or thousands with just 1 click.Or remove them all at once. Easy-peasy", 'molongui-authorship' ),
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade same-width',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $tools = array_merge( $tools, apply_filters( '_authorship/options/guest/tools/markup', $guest_tools ) );
    $tools[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'header',
        'id'       => 'tools_misc_header',
        'deps'     => 'enable_cache',
        'class'    => '',
        'label'    => __( "Misc", 'molongui-authorship' ),
        'buttons'  => array(),
        'search'   => '',
    );
    $tools[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'button',
        'deps'     => '',
        'class'    => 'is-compact',
        'label'    => __( "Clear object cache used by the plugin", 'molongui-authorship' ),
        'button'   => array
        (
            'display'  => true,
            'type'     => 'action',
            'id'       => 'clear-cache',
            'label'    => __( "Clear", 'molongui-authorship' ),
            'title'    => __( "Clear Cache", 'molongui-authorship' ),
            'class'    => 'm-clear-cache same-width',
            'disabled' => false,
        ),
        'search'   => '',
    );
}