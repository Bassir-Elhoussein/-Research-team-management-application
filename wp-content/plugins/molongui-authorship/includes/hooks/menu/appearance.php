<?php
defined( 'ABSPATH' ) or exit;
function authorship_add_theme_menu_items()
{
    $options = authorship_get_options();

    if ( authorship_is_feature_enabled( 'box' ) and $options['appearance_submenu'] )
    {
        add_theme_page
        (
            '',
            _x( "Author Box", "Settings submenu title", 'molongui-authorship' ),
            'manage_options',
            authorship_editor_url(),
            '',
            1
        );
    }
}
add_action( 'admin_menu', 'authorship_add_theme_menu_items' );