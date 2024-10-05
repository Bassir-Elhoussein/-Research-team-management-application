<?php
defined( 'ABSPATH' ) or exit;
function authorship_register_edit_post_scripts()
{
    $file = apply_filters( 'authorship/edit_post/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/edit-post.ab7c.min.js' );

    $deps = array( 'jquery', 'molongui-selectr' );
    if ( authorship_is_feature_enabled( 'multi' ) ) $deps[] = 'molongui-sortable';

    authorship_register_script( $file, 'edit_post', $deps );
}
add_action( 'admin_enqueue_scripts', 'authorship_register_edit_post_scripts' );
function authorship_enqueue_edit_post_scripts()
{
    $screen = get_current_screen();
    if ( !in_array( $screen->id, molongui_enabled_post_screens( MOLONGUI_AUTHORSHIP_PREFIX, 'all' ) )
         or
        ( !current_user_can( 'edit_others_posts' ) and !current_user_can( 'edit_others_pages' ) )
    )
    {
        return;
    }
    molongui_enqueue_selectr();
    if ( authorship_is_feature_enabled( 'multi' ) ) molongui_enqueue_sortable();
    $file = apply_filters( 'authorship/edit_post/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/edit-post.ab7c.min.js' );

    authorship_enqueue_script( $file, 'edit_post', true );
}
add_action( 'admin_enqueue_scripts', 'authorship_enqueue_edit_post_scripts' );
function authorship_edit_post_script_params()
{
    $params = array
    (
        'guest_enabled'     => authorship_is_feature_enabled( 'guest' ),
        'select_author_tip' => authorship_is_feature_enabled( 'multi' ) ? esc_html__( "Select an(other) author...", 'molongui-authorship' ) : esc_html__( "Select an author", 'molongui-authorship' ),
        'remove_author_tip' => esc_html__( "Remove author from selection", 'molongui-authorship' ),
        'guest_name_error'  => esc_html__( "You must provide a guest author display name", 'molongui-authorship' ),
        'ajax_fn_error'     => esc_html__( "Something went wrong. Guest author not added", 'molongui-authorship' ),
        'ajax_call_error'   => esc_html__( "Something went wrong. Can't connect to backend", 'molongui-authorship' ),
    );
    return apply_filters( 'authorship/edit_post/script_params', $params );
}