<?php
defined( 'ABSPATH' ) or exit;
function authorship_autoadd_box()
{
    $options = authorship_get_options();
    if ( empty( $options['author_box'] ) ) return;
    if ( empty( $options['box_hook_priority'] ) ) $options['box_hook_priority'] = 11;
    if ( $options['box_hook_priority'] <= 10 )
    {
        remove_filter( 'the_content', 'wpautop' );
        add_filter( 'the_content', 'wpautop', $options['box_hook_priority'] - 1 );
    }
    add_filter( 'the_content', 'authorship_render_box', $options['box_hook_priority'], 1 );
}
add_action( 'init', 'authorship_autoadd_box' );
function authorship_dont_autoadd_box()
{
    $autoadd = false;

    if ( ( ( is_single() or is_page() ) and in_the_loop() and is_main_query() )
         or
         ( wp_doing_ajax() and is_main_query() )
    ) $autoadd = true;

    return $autoadd;
}
add_filter( 'authorship/render_box', 'authorship_dont_autoadd_box', 9 );