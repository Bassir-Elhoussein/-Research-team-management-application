<?php
defined( 'ABSPATH' ) or exit;
function authorship_register_edit_guest_scripts()
{
    $file = apply_filters( 'authorship/edit_guest/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/edit-guest.xxxx.min.js' );

    authorship_register_script( $file, 'edit_guest' );
}
add_action( 'admin_enqueue_scripts', 'authorship_register_edit_guest_scripts' );
function authorship_enqueue_edit_guest_scripts()
{
    $screen = get_current_screen();
    if ( !in_array( $screen->id, array( 'edit-'.MOLONGUI_AUTHORSHIP_CPT, MOLONGUI_AUTHORSHIP_CPT ) ) ) return;
    $file = apply_filters( 'authorship/edit_guest/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/edit-guest.xxxx.min.js' );

    authorship_enqueue_script( $file, 'edit_guest', true );
}
add_action( 'admin_enqueue_scripts', 'authorship_enqueue_edit_guest_scripts' );
function authorship_edit_guest_script_params()
{
    $params = array
    (
    );
    return apply_filters( 'authorship/edit_guest/script_params', $params );
}