<?php
defined( 'ABSPATH' ) or exit;
function authorship_register_common_options_styles()
{
    $file = apply_filters( 'authorship/options/common_styles', MOLONGUI_AUTHORSHIP_FOLDER . ( is_rtl() ? '/assets/css/common/options-rtl.140b.min.css' : '/assets/css/common/options.1909.min.css' ) );
    $deps = array();

    authorship_register_style( $file, 'common_options', $deps );
}
add_action( 'admin_enqueue_scripts', 'authorship_register_common_options_styles' );
function authorship_enqueue_common_options_styles()
{
    $file = apply_filters( 'authorship/options/common_styles', MOLONGUI_AUTHORSHIP_FOLDER . ( is_rtl() ? '/assets/css/common/options-rtl.140b.min.css' : '/assets/css/common/options.1909.min.css' ) );

    authorship_enqueue_style( $file, 'common_options', true );
}
function authorship_common_options_extra_styles()
{
    $css = '';
    $css .= molongui_get_admin_color();
    return apply_filters( 'authorship/options/common_extra_styles', $css );
}