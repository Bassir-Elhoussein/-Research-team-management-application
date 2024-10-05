<?php
defined( 'ABSPATH' ) or exit;
function authorship_register_support_styles()
{
    $file = apply_filters( 'authorship/support/styles', MOLONGUI_AUTHORSHIP_FOLDER . ( is_rtl() ? '/assets/css/common/support-rtl.7160.min.css' : '/assets/css/common/support.5779.min.css' ) );
    $deps = array();

    authorship_register_style( $file, 'support', $deps );
}
add_action( 'admin_enqueue_scripts', 'authorship_register_support_styles' );
function authorship_enqueue_support_styles()
{
    $file = apply_filters( 'authorship/support/styles', MOLONGUI_AUTHORSHIP_FOLDER . ( is_rtl() ? '/assets/css/common/support-rtl.7160.min.css' : '/assets/css/common/support.5779.min.css' ) );

    authorship_enqueue_style( $file, 'support', true );
}
function authorship_support_extra_styles()
{
    $css = '';
    $css .= molongui_get_admin_color();
    return apply_filters( 'authorship/support/extra_styles', $css );
}