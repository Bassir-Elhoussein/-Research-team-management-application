<?php
defined( 'ABSPATH' ) or exit;
function authorship_register_editor_scripts()
{
    $file = apply_filters( 'authorship/editor/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/editor.4098.min.js' );

    authorship_register_script( $file, 'editor' );
}
add_action( 'admin_enqueue_scripts', 'authorship_register_editor_scripts' );
function authorship_enqueue_editor_scripts()
{
    $file = apply_filters( 'authorship/editor/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/editor.4098.min.js' );

    authorship_enqueue_script( $file, 'editor', true );
}
function authorship_editor_script_params()
{
    $params = array
    (
    );
    return apply_filters( 'authorship/editor/script_params', $params );
}