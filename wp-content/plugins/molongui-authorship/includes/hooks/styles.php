<?php
defined( 'ABSPATH' ) or exit;
function authorship_register_admin_styles()
{
    $file = apply_filters( 'authorship/admin/styles', MOLONGUI_AUTHORSHIP_FOLDER . ( is_rtl() ? '/assets/css/admin-rtl.4e67.min.css' : '/assets/css/admin.8d87.min.css' ) );
    $deps = array( 'wp-color-picker' );

    authorship_register_style( $file, 'admin', $deps );
}
add_action( 'admin_enqueue_scripts', 'authorship_register_admin_styles' );
function authorship_enqueue_admin_styles()
{
    $screen  = get_current_screen();
    $screens = array_merge
    (
        molongui_enabled_post_screens( MOLONGUI_AUTHORSHIP_PREFIX, 'all' ),
        array
        (
            'profile', 'users', 'user', 'user-edit',
            MOLONGUI_AUTHORSHIP_CPT, 'edit-'.MOLONGUI_AUTHORSHIP_CPT,
            'authors_page_molongui-authorship',
            'molongui_page_molongui-authorship',
            'toplevel_page_authors',
        )
    );
    if ( !in_array( $screen->id, $screens ) ) return;
    wp_enqueue_style( 'wp-color-picker' );
    $file = apply_filters( 'authorship/admin/styles', MOLONGUI_AUTHORSHIP_FOLDER . ( is_rtl() ? '/assets/css/admin-rtl.4e67.min.css' : '/assets/css/admin.8d87.min.css' ) );

    authorship_enqueue_style( $file, 'admin', true );
}
add_action( 'admin_enqueue_scripts', 'authorship_enqueue_admin_styles' );
function authorship_admin_extra_styles()
{
    $css = '';
    $css .= "";
    return apply_filters( 'authorship/admin/extra_styles', $css );
}
function authorship_inline_styles()
{
    $options = authorship_get_options();

    if ( $options['guest_authors'] or $options['enable_multi_authors'] )
    {
        ?>
        <style>
            .molongui-disabled-link
            {
                border-bottom: none !important;
                text-decoration: none !important;
                color: inherit !important;
                cursor: inherit !important;
            }
            .molongui-disabled-link:hover,
            .molongui-disabled-link:hover span
            {
                border-bottom: none !important;
                text-decoration: none !important;
                color: inherit !important;
                cursor: inherit !important;
            }
        </style>
        <?php
    }
}
add_action( 'wp_head', 'authorship_inline_styles' );