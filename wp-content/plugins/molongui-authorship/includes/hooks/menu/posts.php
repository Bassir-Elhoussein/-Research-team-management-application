<?php
defined( 'ABSPATH' ) or exit;
function authorship_add_posts_menu_items()
{
    $options = authorship_get_options();

    if ( $options['posts_submenu'] )
    {
        add_posts_page
        (
            '',
            _x( "Authors", "Posts submenu title", 'molongui-authorship' ),
            'manage_options',
            'admin.php?page=authors',
            '',
            2
        );
    }
}
add_action( 'admin_menu', 'authorship_add_posts_menu_items' );