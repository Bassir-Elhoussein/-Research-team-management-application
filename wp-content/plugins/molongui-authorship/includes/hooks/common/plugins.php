<?php
defined( 'ABSPATH' ) or exit;
if ( did_action( '_molongui/plugins/loaded' ) ) return;

$file     = MOLONGUI_AUTHORSHIP_FOLDER . ( is_rtl() ? '/assets/css/common/plugins-rtl.88ed.min.css' : '/assets/css/common/plugins.2d57.min.css' );
$filepath = trailingslashit( WP_PLUGIN_DIR ) . $file;
if ( file_exists( $filepath ) )
{
    add_filter( '_molongui/plugins/stylesheet', function() use ( $file ){ return $file; }, 10 );

    $filesize = filesize( $filepath );
    if ( $filesize > 4096 )
    {
        add_filter( 'molongui/plugins/inline/stylesheet', '__return_false', 0 );
        add_action( 'admin_enqueue_scripts', 'authorship_load_plugins_styles' );
    }
    elseif ( $filesize )
    {
        add_filter( 'molongui/plugins/inline/stylesheet', '__return_true', 0 );
        add_action( 'admin_head', 'authorship_load_plugins_styles' );
    }
}
function authorship_load_plugins_styles()
{
    $screen = get_current_screen();

    if ( 'toplevel_page_molongui' === $screen->id )
    {
        if ( $file = apply_filters( '_molongui/plugins/stylesheet', false ) )
        {
            $inline = apply_filters( 'molongui/plugins/inline/stylesheet', true );
            if ( $inline )
            {
                echo '<style>' . molongui_get_admin_color() . '</style>';

                $styles = file_get_contents( trailingslashit( WP_PLUGIN_DIR ) . $file );
                echo '<style id="' . MOLONGUI_AUTHORSHIP_NAME . '-plugins-inline-css" type="text/css" data-file="'.basename( $file ).'">' . $styles . '</style>';
            }
            else
            {
                wp_register_style( MOLONGUI_AUTHORSHIP_NAME, plugins_url( '/' ).$file, array(), MOLONGUI_AUTHORSHIP_VERSION, 'screen' );
                wp_add_inline_style( MOLONGUI_AUTHORSHIP_NAME, molongui_get_admin_color() );
                wp_enqueue_style( MOLONGUI_AUTHORSHIP_NAME );
            }
        }
    }
}
$file     = MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/common/plugins.nnnn.min.js';
$filepath = trailingslashit( WP_PLUGIN_DIR ) . $file;

if ( file_exists( $filepath ) )
{
    add_filter( '_molongui/plugins/scripts', function() use ( $file ){ return $file; }, 10 );

    $filesize = filesize( $filepath );
    if ( $filesize > 4096 )
    {
        add_filter( 'molongui/plugins/inline/scripts', '__return_false', 0 );
        add_action( 'admin_enqueue_scripts', 'authorship_load_plugins_scripts', 99 );
    }
    elseif ( $filesize )
    {
        add_filter( 'molongui/plugins/inline/scripts', '__return_true', 0 );
        add_action( 'admin_footer-toplevel_page_molongui', 'authorship_load_plugins_scripts' );
    }
}
function authorship_load_plugins_scripts()
{
    if ( $file = apply_filters( '_molongui/plugins/scripts', false ) )
    {
        $inline = apply_filters( 'molongui/plugins/inline/scripts', true );
        if ( $inline )
        {
            $scripts = file_get_contents( trailingslashit( WP_PLUGIN_DIR ) . $file );
            echo '<script id="' . MOLONGUI_AUTHORSHIP_NAME . '-plugins-inline-js" type="text/javascript" data-file="'.basename( $file ).'">' . $scripts . '</script>';
        }
        else
        {
            wp_register_script( MOLONGUI_AUTHORSHIP_NAME, plugins_url( '/' ).$file, array( 'jquery' ), MOLONGUI_AUTHORSHIP_VERSION, true );
            wp_enqueue_script( MOLONGUI_AUTHORSHIP_NAME );
        }
    }
}


/*!
 * PRIVATE ACTION HOOK.
 *
 * For internal use only. Not intended to be used by plugin or theme developers.
 * Future compatibility NOT guaranteed.
 *
 * Please do not rely on this hook for your custom code to work. As a private hook it is meant to be used only by
 * Molongui. It may be edited, renamed or removed from future releases without prior notice or deprecation phase.
 *
 * If you choose to ignore this notice and use this filter, please note that you do so at on your own risk and knowing
 * that it could cause code failure.
 */
do_action( '_molongui/plugins/loaded' );