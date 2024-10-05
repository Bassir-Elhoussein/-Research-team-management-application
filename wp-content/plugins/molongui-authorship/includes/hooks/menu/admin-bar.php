<?php
defined( 'ABSPATH' ) or exit;
function authorship_ab_new_items()
{
    $options = authorship_get_options();
    if ( !$options['authors_menu'] ) return;

    global $wp_admin_bar;

    $wp_admin_bar->add_menu( array
    (
        'parent' => 'new-content',
        'id'     => 'new-author',
        'title'  => __( 'Author' ),
        'href'   => admin_url( 'admin.php?page=author-new' ),
    ));
}
add_action( 'wp_before_admin_bar_render', 'authorship_ab_new_items' );