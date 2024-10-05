<?php
defined( 'ABSPATH' ) or exit;
function authorship_admin_menu()
{
    global $submenu;
    if ( !current_user_can( 'manage_options' ) ) return;
    if ( empty( $GLOBALS['admin_page_hooks']['molongui'] ) )
    {
        $position = 30;
        add_menu_page( "Molongui", "Molongui", 'manage_options', 'molongui', 'authorship_render_plugins_page', molongui_get_base64_svg( authorship_get_admin_icon() ), $position );
        add_submenu_page( 'molongui', __( "Plugins", 'molongui-authorship' ), __( "Plugins", 'molongui-authorship' ), 'manage_options', 'molongui', 'authorship_render_plugins_page' );
        add_submenu_page( 'molongui', __( "Support", 'molongui-authorship' ), __( "Support", 'molongui-authorship' ), 'manage_options', 'molongui-support', 'authorship_render_support_page' );
        $submenu['molongui']['molongui-docs'] = array( __( "Docs", 'molongui-authorship' ), 'manage_options', 'https://www.molongui.com/docs/' );
    }
    if ( !did_action( 'authorship_pro/loaded' ) )
    {
        $submenu['molongui']['molongui-demos'] = array( __( "Test Pro!", 'molongui-authorship' ), 'manage_options', 'https://demos.molongui.com/' );
    }
    add_submenu_page( 'molongui', ucfirst( sprintf( __( "%s Settings", 'molongui-authorship' ), MOLONGUI_AUTHORSHIP_TITLE ) ), ucfirst( sprintf( __( "%s Settings", 'molongui-authorship' ), MOLONGUI_AUTHORSHIP_TAG ) ), 'manage_options', MOLONGUI_AUTHORSHIP_NAME, 'authorship_render_settings_page' );
    authorship_reorder_submenu_items();
}
add_action( 'admin_menu', 'authorship_admin_menu' );
function authorship_menu_item_styles()
{
    ?>
    <style>
        #adminmenu li#toplevel_page_molongui { margin: 11px 0; }
    </style>
    <?php
}
add_action( 'admin_head', 'authorship_menu_item_styles' );