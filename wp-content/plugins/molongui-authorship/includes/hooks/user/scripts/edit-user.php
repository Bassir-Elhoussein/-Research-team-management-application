<?php
defined( 'ABSPATH' ) or exit;
function authorship_register_edit_user_scripts()
{
    $file = apply_filters( 'authorship/edit_user/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/edit-user.xxxx.min.js' );

    authorship_register_script( $file, 'edit_user' );
}
add_action( 'admin_enqueue_scripts', 'authorship_register_edit_user_scripts' );
function authorship_enqueue_edit_user_scripts()
{
    $screen = get_current_screen();
    if ( !in_array( $screen->id, array( 'profile', 'users', 'user', 'user-edit' ) ) ) return;
    $file = apply_filters( 'authorship/edit_user/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/edit-user.xxxx.min.js' );

    authorship_enqueue_script( $file, 'edit_user', true );
}
add_action( 'admin_enqueue_scripts', 'authorship_enqueue_edit_user_scripts' );
function authorship_edit_user_script_params()
{
    $params = array
    (
    );
    return apply_filters( 'authorship/edit_user/script_params', $params );
}