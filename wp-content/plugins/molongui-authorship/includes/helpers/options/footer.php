<?php
defined( 'ABSPATH' ) or exit;
function authorship_options_footer()
{
    $plugin_url = MOLONGUI_AUTHORSHIP_WEB;
    $docs_url   = 'https://www.molongui.com/docs/' . MOLONGUI_AUTHORSHIP_NAME;

    return apply_filters( 'authorship/options_footer_items', array
    (
        'links' => array
        (
            array
            (
                'label'   => __( "Free", 'molongui-authorship' ) . " " . MOLONGUI_AUTHORSHIP_VERSION,
                'tip'     => __( "Check out all plugin features", 'molongui-authorship' ),
                'prefix'  => '<span class="m-page-footer__version">',
                'suffix'  => '</span>',
                'href'    => $plugin_url,
                'target'  => '_blank',
                'display' => true,
            ),
            array
            (
                'label'   => __( "Changelog", 'molongui-authorship' ),
                'tip'     => __( "See changelog", 'molongui-authorship' ),
                'prefix'  => '',
                'suffix'  => '',
                'href'    => $docs_url.'/changelog/changelog-free-version/',
                'target'  => '_blank',
                'display' => true,
            ),
            array
            (
                'label'   => __( "Docs", 'molongui-authorship' ),
                'tip'     => __( "Read the plugin documentation", 'molongui-authorship' ),
                'prefix'  => '',
                'suffix'  => '',
                'href'    => $docs_url,
                'target'  => '_blank',
                'display' => true,
            ),
            array
            (
                'label'   => __( "Help", 'molongui-authorship' ),
                'tip'     => __( "Click to get help", 'molongui-authorship' ),
                'prefix'  => '',
                'suffix'  => '',
                'href'    => admin_url( 'admin.php?page=molongui-authorship-help' ),
                'target'  => '_self',
                'display' => true,
            ),
            array
            (
                'label'   => __( "Try Pro", 'molongui-authorship' ),
                'tip'     => __( "Test the Pro version of the plugin for free", 'molongui-authorship' ),
                'prefix'  => '',
                'suffix'  => '',
                'href'    => 'https://demos.molongui.com/test-drive-'.MOLONGUI_AUTHORSHIP_NAME.'-pro/',
                'target'  => '_blank',
                'display' => true,
            ),
            array
            (
                'label'   => __( "Upgrade", 'molongui-authorship' ),
                'tip'     => __( "Go Pro to get access to premium features", 'molongui-authorship' ),
                'prefix'  => '',
                'suffix'  => '',
                'href'    => $plugin_url.'pricing/',
                'target'  => '_blank',
                'display' => true,
            ),
        ),
    ));
}